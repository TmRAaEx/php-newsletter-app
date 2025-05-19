<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function home(): string
    {
        return view('home_page');
    }
    //todo refactor message into a toaster notification
    public function message(): string
{
    $msg = session()->getFlashdata('message');
    return view('message_page', ['message' => $msg ?? '']);
}
}
