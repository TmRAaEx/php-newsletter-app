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
            $userRoleModel = new UserRole();
            $roleModel = new Role();


            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $userModel->where('email', $email)->first();


            if ($user && hash('sha256', $user['salt'] . $password) === $user['password_hash']) {
                $cache->delete($key);


                $userAgent = $this->parseUserAgent($this->request->getUserAgent()->getAgentString());
                $session_token = bin2hex(random_bytes(32));
                $expires_in_ms = 60 * 60 * 24 * 30; // one month
                $sessionModel->save([
                    'user_id' => $user['id'],
                    'session_token' => $session_token,
                    'ip_address' => $this->request->getIPAddress(),
                    'user_agent' => $userAgent,
                    'expires_at' => date('Y-m-d H:i:s', time() + $expires_in_ms)
                ]);


                $userRoles = $userRoleModel->where('user_id', $user['id'])->findAll();

                $roleIds = array_column($userRoles, 'role_id');

                $roles = $roleModel->whereIn('id', $roleIds)->findAll();

                $roleNames = array_column($roles, 'name');

                log_message('info', 'User logged in: ' . $user['email'] . ' with roles: ' . implode(', ', $roleNames));

                session()->set([
                    'session_token' => $session_token,
                    'user_id' => $user['id'],
                    'user_roles' => $roleNames,
                ]);

                return redirect()->to('/message')->with('message', 'Inloggning lyckades!');
            } else {
                $cache->save($key, $attempts + 1, $lockoutMinutes * 60);
                return view('auth/login', ['error' => 'Felaktig e-postadress eller lösenord.']);
            }
        }
        $redirectError = session()->getFlashdata('error');
        $redirectMessage = session()->getFlashdata('message');
        return view('auth/login', ['error' => $redirectError, 'message' => $redirectMessage]);
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


    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }


    //handles the post-requeset from the forgot password form
    //sends an email to the user with a link to reset the password
    public function resetPasswordEmail()
    {

        $userModel = new User();
        $mailgun = Mailgun::create(env('mailgun.api_key'));
        $mailgun_account = env('mailgun.account');

        $passwordResetModel = new \App\Models\PasswordReset();




        $receiver = $this->request->getPost('email');

        $user = $userModel->where('email', $receiver)->first();
        if (!$user) {
            return redirect()->to('login')->with('error', 'Ingen användare med den här e-postadressen finns.');
        }

        $token = bin2hex(random_bytes(16));

        $passwordResetModel->create($receiver, $token);


        $first_name = $user['first_name'];
        $last_name = $user['last_name'];
        $html = view('emails/reset_password', [
            'email' => $receiver,
            'name' => $first_name,
            'link' => base_url("/reset-password?token=$token"),
        ]);
        $result = $mailgun->messages()->send(
            'sandboxd89b984190d5429fa384fdf062fcf67f.mailgun.org',
            [
                'from' => "Newsletters <postmaster@$mailgun_account>",
                'to' => "$first_name $last_name <$receiver>",
                'subject' => 'Återställ lösenord',
                'html' => $html,
            ]
        );

        $message = $result->getMessage();
        if ($message !== 'Queued. Thank you.') {
            return redirect()->to('login')->with('error', 'Ett fel inträffade när e-postmeddelandet skulle skickas.');
        }

        return redirect()->to('/login')->with('message', 'Ett e-postmeddelande har skickats för att återställa ditt lösenord.');
    }


    public function resetPassword()
    {
        $token = $this->request->getGet('token');
        $passwordResetModel = new \App\Models\PasswordReset();

        $passwordReset = $passwordResetModel->validateToken($token); //returns the password reset request if it is valid

        if (!$passwordReset) {
            return redirect()->to('/login')->with('error', 'Länken för att återställa ditt lösenord är ogiltig eller utgången. Vänligen begär en ny återställningslänk.');
        }

        if ($this->request->getMethod() === 'POST') {
            $userModel = new User();
            $user = $userModel->where('email', $passwordReset['email'])->first();

            if (!$user) {
                return redirect()->to('/login')->with('error', 'Ingen användare med den här e-postadressen finns.');
            }

            $newPassword = $this->request->getPost('password');
            $passwordConfirm = $this->request->getPost('password_confirm');

            if ($newPassword != $passwordConfirm) {
                return redirect()->back()->with('error', 'Lösenorden matchar inte.');
            }

            //save the new password 
            //the user->save didnt trigger the beforeUpdate method to hash the password
            //so we have to call the update method manually
            $userModel->update($user['id'], [
                'password_raw' => $newPassword,
            ]);


            //delete the password reset token
            $passwordResetModel->delete($passwordReset['id']);

            return redirect()->to('/login')->with('message', 'Ditt lösenord har återställts. Du kan nu logga in.');
        }

        return view('auth/reset_password', ['token' => $token, 'error' => session()->getFlashdata('error')]);
    }


    protected function parseUserAgent($userAgent)
    {
        $platform = 'Okänt OS';
        $browser = 'Okänd webbläsare';

        // Platform
        if (preg_match('/linux/i', $userAgent)) {
            $platform = 'Linux';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $platform = 'Mac';
        } elseif (preg_match('/windows|win32/i', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/iphone/i', $userAgent)) {
            $platform = 'iPhone';
        } elseif (preg_match('/android/i', $userAgent)) {
            $platform = 'Android';
        }

        // browser
        if (preg_match('/MSIE/i', $userAgent) || preg_match('/Trident/i', $userAgent)) {
            $browser = 'Internet Explorer';
        } elseif (preg_match('/Edge/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Opera/i', $userAgent)) {
            $browser = 'Opera';
        }

        return "$platform, $browser";
    }




}

