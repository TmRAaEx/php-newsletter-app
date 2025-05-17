<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use App\Models\Session;
use App\Helpers\AuthHelper;
/**
 * AuthFilter
 *
 * This filter checks if the user is logged in by verifying the session token and user ID.
 * If the user is not logged in, they are redirected to the login page.
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = AuthHelper::isLoggedIn();

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
