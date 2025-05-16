<?php



namespace App\Controllers;
use App\Models\User;



class Profile extends BaseController
{
    public function index(): string
    {
        $userModel = new User();
        $userId = session('user_id');
        $user = $userModel->find($userId);

        return view('profile', ['user' => $user]);
    }
}