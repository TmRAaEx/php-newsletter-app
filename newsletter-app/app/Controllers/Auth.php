<?php

namespace App\Controllers;

use CodeIgniter\Database\Query;

class Auth extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function register(): string
    {
        return view('home_page');
    }

}
