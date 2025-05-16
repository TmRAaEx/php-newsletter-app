<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use App\Models\Session;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $sessionToken = session('session_token');
        $userId = session('user_id');

        if (!$sessionToken || !$userId) {
            return redirect()->to('/login')->with('error', 'Du måste vara inloggad.');
        }

        // Check if the session token is valid
        $sessionModel = new Session();
        $session = $sessionModel
            ->where('session_token', $sessionToken)
            ->where('user_id', $userId)
            ->where('expires_at >=', date('Y-m-d H:i:s'))
            ->first();

        if (!$session) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Din session har gått ut.');
        }


        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}
