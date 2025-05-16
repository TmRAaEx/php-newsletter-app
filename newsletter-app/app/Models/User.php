<?php


namespace App\Models;

use CodeIgniter\Model;


class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'first_name',
        'last_name',
        'email',
        'password_hash',
        'salt',
        'created_at',
        'updated_at',
        'password_raw' //only for validation
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $beforeInsert = ['generateSaltAndHashPassword'];
    protected $beforeUpdate = ['generateSaltAndHashPassword'];


    protected $validationRules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password_raw' => 'required|min_length[6]',
    ];

    protected function generateSaltAndHashPassword(array $data)
    {
        if (!isset($data['data']['password_raw'])) {
            return $data;
        }

        $salt = bin2hex(random_bytes(16));
        $data['data']['salt'] = $salt;
        $data['data']['password_hash'] = hash('sha256', $salt . $data['data']['password_raw']);
        unset($data['data']['password_raw']);

        return $data;
    }

}