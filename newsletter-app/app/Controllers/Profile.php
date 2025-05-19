<?php



namespace App\Controllers;
use App\Models\User;



class Profile extends BaseController
{
    public function index(): string
    {
        $sessionModel = new \App\Models\Session();
        $userModel = new User();
        $userId = session('user_id');


        $user = $userModel->find($userId);
        $sessions = $sessionModel->where('user_id', $userId)->findAll();



        return view('profile', ['user' => $user, 'sessions' => $sessions]);
    }
}