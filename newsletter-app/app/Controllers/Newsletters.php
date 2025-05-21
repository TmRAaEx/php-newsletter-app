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
        $subscriptionModel = new \App\Models\Subscription();
        $userId = session('user_id');

        $subsciption = $subscriptionModel->where(['user_id' => $userId, 'newsletter_id' => $id])->first();
        $isSubscribed = $subsciption ? true : false;

        $newsletter = $newsletterModel->find($id);

        return view("newsletters/newsletter", ['newsletter' => $newsletter, 'isSubscribed' => $isSubscribed]);
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


    public function editNewsletter($id)
    {
        $newsletterModel = new Newsletter();
        $newsletter = $newsletterModel->find($id);
        $user_id = session('user_id');

        if ($newsletter['customer_id'] !== $user_id) {
            return view('newsletters/edit', ['error' => 'Du äger inte detta nyhetsbrev!']);
        }

        $error = session()->getFlashData('error');

        //handle post request
        if ($this->request->getMethod() == 'POST') {
            $name = $this->request->getPost('name');
            $description = $this->request->getPost('description');


            if (empty($name) || empty($description)) {
                return redirect()->back()->with('error', 'Alla fält måste fyllas i.');
            }

            $data = [
                'name' => $name,
                'description' => $description
            ];

            $newsletterModel->update($id, $data);

            return redirect()->to('newsletters/my-newsletters')->with('message', 'Uppdaterade nyhetsbrev #id:' . $id);
        }

        return view('newsletters/edit', ['newsletter' => $newsletter, 'error' => $error]);
    }
}