<?php


namespace App\Models;

use CodeIgniter\Model;

class Session extends Model
{
    protected $table = 'sessions';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'session_token',
        'ip_address',
        'user_agent',
        'expires_at',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'user_id' => 'required|integer',
        'session_token' => 'required|string|max_length[255]',
    ];
}
