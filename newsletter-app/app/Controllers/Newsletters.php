<?php

namespace App\Controllers;

use App\Models\Newsletter;


class Newsletters extends BaseController
{
    public function index()
    {
        $newsletterModel = new Newsletter();

        $newsletters = $newsletterModel->findAll();



        return view("newsletters/newsletters", ['newsletters' => $newsletters]);
    }

    public function single($id)
    {
        $newsletterModel = new Newsletter();

        $newsletter = $newsletterModel->find($id);

        return view("newsletters/newsletter", ['newsletter' => $newsletter]);
    }

    public function subscribe()
    {
        $newsletterModel = new Newsletter();
        $subscriptionModel = new \App\Models\Subscription();
        $newsletterId = $this->request->getPost('newsletter_id');

        $newsletter = $newsletterModel->find($newsletterId);
        $userId = $this->request->getPost('user_id');



        if ($newsletter) {
            $data = [
                'user_id' => $userId,
                'newsletter_id' => $newsletterId,
                'subscribed_at' => date('Y-m-d H:i:s'),
            ];
            if ($subscriptionModel->where(['user_id' => $userId, 'newsletter_id' => $newsletterId])->first()) {
                return redirect()->to('/newsletters')->with('error', 'Already subscribed to this newsletter.');
            }

            $subscriptionModel->insert($data);

            return redirect()->to('/newsletters')->with('message', 'Subscribed successfully!');
        } else {
            return redirect()->to('/newsletters')->with('error', 'Newsletter not found.');
        }
    }
}