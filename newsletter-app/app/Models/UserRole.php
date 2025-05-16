<?php
namespace App\Models;

use CodeIgniter\Model;

class UserRole extends Model
{
    protected $table = 'user_roles';
    protected $allowedFields = ['user_id', 'role_id'];
    public $timestamps = false;
}
