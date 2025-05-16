<?php

namespace App\Controllers;

use App\Models\Newsletter;


class newsletters extends BaseController

{
    public function index()
    {
        $newsletterModel = new Newsletter();

        $newsletters = $newsletterModel->findAll();

        

        return view("newsletters", ['newsletters'=> $newsletters]);
    }

    public function Single($id)
    {
        $newsletterModel = new Newsletter();

        $newsletter = $newsletterModel->find($id);
    

        return view("newsletter", ['newsletter'=> $newsletter]);
    }
}