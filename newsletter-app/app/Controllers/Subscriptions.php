<?php

namespace App\Controllers;


use App\Models\Subscription;
use App\Models\Newsletter;
use App\Models\User;

class Subscriptions extends BaseController
{
    public function subscriptions()
    {
        $subscriptionModel = new Subscription();
        $newsletterModel = new Newsletter();

        $userId = session()->get('user_id');
        $subscriptions = $subscriptionModel
            ->where('user_id', $userId)
            ->findAll();


        $newsletters = [];

        $newsletterIds = array_column($subscriptions, 'newsletter_id');


        if (!empty($newsletterIds)) {
            $newsletters = $newsletterModel
                ->whereIn('id', $newsletterIds)
                ->findAll();
        }

        return view('subscriptions', ['newsletters' => $newsletters]);
    }

    public function subscribers()
    {
        $subscriptionModel = new Subscription();
        $userModel = new User();
        $newsletterModel = new Newsletter();

        $userId = session()->get('user_id');

        $myNewsletters = $newsletterModel
            ->where('customer_id', $userId)
            ->findAll();

        $myNewsletterIds = array_column($myNewsletters, 'id');

        $subscritions = [];
        $subscribers = [];

        if (!empty($myNewsletterIds)) {
            $subscriptions = $subscriptionModel
                ->whereIn('newsletter_id', $myNewsletterIds)
                ->findAll();
        }

        if (!empty($subscriptions)) {
            $subscriberIds = array_column($subscriptions, 'user_id');
            $subscribers = $userModel
                ->whereIn('id', $subscriberIds)
                ->findAll();
        }


        return view('subscribers', [
            'newsletters' => $myNewsletters,
            'subscriptions' => $subscriptions,
            'subscribers' => $subscribers
        ]);
    }
}