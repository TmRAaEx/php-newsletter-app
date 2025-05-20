<?php


namespace App\Models;

use CodeIgniter\Model;


class PasswordReset extends Model
{
    protected $table = 'password_resets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'token', 'created_at', 'expires_at'];

    protected $validationRules = [
        'email' => 'required|valid_email',
        'token' => 'required',
    ];

    public function validateToken($token)
    {
        return $this
            ->where('token', $token)
            ->where('expires_at >=', date('Y-m-d H:i:s'))
            ->first();
    }

    public function create($email, $token)
    {
        return $this
            ->insert([
                'email' => $email,
                'token' => $token,
                'created_at' => date('Y-m-d H:i:s'),
                'expires_at' => date('Y-m-d H:i:s', strtotime('+20 minutes'))
            ]);
    }

    public function deleteToken($email)
    {
        return $this
            ->where('email', $email)
            ->delete();
    }

    public function deleteExpiredTokens()
    {
        return $this->where('expires_at <', date('Y-m-d H:i:s'))->delete();
    }
}