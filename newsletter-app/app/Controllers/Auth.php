<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Session;
use App\Models\Role;
use App\Models\UserRole;
use Mailgun\Mailgun;

class Auth extends BaseController
{
    public function register()
    {
        $roleModel = new Role();

        if ($this->request->getMethod() === 'POST') {

            $userModel = new User();
            $userRoleModel = new UserRole();

            $data = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'password_raw' => $this->request->getPost('password'), // raw password
            ];

            $role = $this->request->getPost('role_id');


            if (!$userModel->save($data)) {
                $errors = $userModel->errors();
                if (empty($errors)) {
                    $errors = ['db' => $userModel->db->error()['message']];
                }

                $userId = $userModel->getInsertID();

                if ($role) {
                    $userRoleModel->insert([
                        'user_id' => $userId,
                        'role_id' => $role
                    ]);
                }

                return view('auth/register', ['errors' => $errors]);
            }
            return redirect()->to('/login')->with('message', 'Registrering lyckades! Du kan nu logga in.');
        } else {

            $roles = $roleModel->findAll();

            return view('auth/register', ['roles' => $roles]);
        }
    }

    public function login()
    {

        $ip = $this->request->getIPAddress();
        $cache = \Config\Services::cache();
        $key = 'login_attempts_' . $ip;
        $maxAttempts = 5;
        $lockoutMinutes = 10;

        $attempts = $cache->get($key) ?? 0;


        if ($attempts >= $maxAttempts) {
            return view('auth/login', [
                'error' => "För många misslyckade försök. Försök igen om $lockoutMinutes minuter."
            ]);
        }

        if ($this->request->getMethod() === 'POST') {
            $userModel = new User();
            $sessionModel = new Session();


            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $userModel->where('email', $email)->first();


            if ($user && hash('sha256', $user['salt'] . $password) === $user['password_hash']) {
                $cache->delete($key);



                $session_token = bin2hex(random_bytes(32));
                $expires_in_ms = 60 * 60 * 24 * 30; // one month
                $sessionModel->save([
                    'user_id' => $user['id'],
                    'session_token' => $session_token,
                    'ip_address' => $this->request->getIPAddress(),
                    'user_agent' => $this->request->getUserAgent()->getAgentString(),
                    'expires_at' => date('Y-m-d H:i:s', time() + $expires_in_ms)
                ]);

                session()->set([
                    'session_token' => $session_token,
                    'user_id' => $user['id'],
                    'logged_in' => true,
                ]);

                return redirect()->to('/message')->with('message', 'Inloggning lyckades!');
            } else {
                $cache->save($key, $attempts + 1, $lockoutMinutes * 60);
                return view('auth/login', ['error' => 'Felaktig e-postadress eller lösenord.']);
            }
        }
        $redirectError = session()->getFlashdata('error');
        return view('auth/login', ['error' => $redirectError]);
    }


    public function logout()
    {
        \App\Helpers\AuthHelper::logout();
        return redirect()->to('/message')->with('message', 'Du har loggat ut.');
    }

    public function logOutAll()
    {
        \App\Helpers\AuthHelper::logOutAll();
        return redirect()->to('/message')->with('message', 'Du har loggats ut från alla enheter.');
    }


    public function resetPasswordMail()
    {

        $userModel = new User();
        $mailgun = Mailgun::create(env('mailgun.api_key'));
        $mailgun_account = env('mailgun.account');


        $receiver = $this->request->getPost('email');

        $user = $userModel->where('email', $receiver)->first();
        if (!$user) {
            return redirect()->to('login')->with('error', 'Ingen användare med den här e-postadressen finns.');
        }

        $html = view('emails/reset_password', [
            'email' => $receiver,
            'name' => $user['first_name'],
            'link' => base_url('/reset-password')
        ]);
        $result = $mailgun->messages()->send(
            'sandboxd89b984190d5429fa384fdf062fcf67f.mailgun.org',
            [
                'from' => "Mailgun Sandbox <postmaster@$mailgun_account>",
                'to' => $receiver,
                'subject' => 'Återställ lösenord',
                'html' => $html,
            ]
        );

        return $result->getMessage();
    }
}
