<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Session;

class Auth extends BaseController
{
    public function register()
    {
        if ($this->request->getMethod() === 'POST') {

            $userModel = new User();

            $data = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'password_raw' => $this->request->getPost('password'), // raw password
            ];

            if (!$userModel->save($data)) {
                $errors = $userModel->errors();
                if (empty($errors)) {
                    $errors = ['db' => $userModel->db->error()['message']];
                }

                return view('auth/register', ['errors' => $errors]);
            }
            return redirect()->to('/login')->with('message', 'Registrering lyckades! Du kan nu logga in.');
        } else {
            return view('auth/register');
        }
    }

    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            $userModel = new User();
            $sessionModel = new Session();
            

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $userModel->where('email', $email)->first();

            
            if ($user && hash('sha256', $user['salt'] . $password) === $user['password_hash']) {
                
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
                    'user_id'       => $user['id'],
                    'logged_in'     => true,
                ]);

                return redirect()->to('/')->with('message', 'Inloggning lyckades!');
            } else {
                return view('auth/login', ['error' => 'Felaktig e-postadress eller lösenord.']);
            }
        }

        return view('auth/login');
    }
}
