<?php

namespace App\Controllers;

use App\Models\User;
class Auth extends BaseController
{
    public function register(): string
    {
        if ($this->request->getMethod() === 'post') {
            $userModel = new User();

            $data = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'password_hash' => $this->request->getPost('password'), 
            ];

            if (!$userModel->save($data)) {
                
                $errors = $userModel->errors(); 
                if (empty($errors)) {
                    $errors = $userModel->db->error();
                }

                return view('auth/register', ['errors' => $errors]);
            }
        }
        return view('register');
    }
}
