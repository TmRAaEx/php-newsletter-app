<?php

namespace App\Controllers;

use App\Models\User;

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
        if ($this->request->getMethod() === 'post') {
            $userModel = new User();

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $userModel->where('email', $email)->first();

            if ($user && hash('sha256', $user['salt'] . $password) === $user['password_hash']) {
                // Set session data
                session()->set('logged_in', true);
                session()->set('user_id', $user['id']); 

                return redirect()->to('/')->with('message', 'Inloggning lyckades!');
            } else {
                return view('auth/login', ['error' => 'Felaktig e-postadress eller lösenord.']);
            }
        }

        return view('auth/login');
    }
}
