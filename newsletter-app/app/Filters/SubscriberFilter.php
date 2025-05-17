<?php


namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;


use App\Models\User;
use App\Helpers\AuthHelper;
/**
 * SubscriberFilter
 *
 * This filter checks if the user is a subscriber.
 * If the user is not a subscriber, they are redirected to the home page with an error message.
 */
class SubscriberFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        $session = AuthHelper::isLoggedIn();
        if (!$session) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Din session har gått ut.');
        }
        // Check if the user is a subscriber
        $userId = session('user_id');
        $userModel = new User();

        $user = $userModel->where('id', $userId)->first();

        if (!$user || $user['role'] !== 'subscriber') {
            return redirect()->to('/')->with('error', 'Du måste vara inloggad som prenumerant.');
        }

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something after the request
    }

}