<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

use App\Helpers\AuthHelper;
/**
 * AuthFilter
 *
 * This filter checks if the user is logged in by verifying the session token and user ID.
 * If the user is logged in, they are redirected to the profile page.
 */
class NoAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = AuthHelper::validateSession();

        if ($session) {
            return redirect()->to('/profile');
        }
        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}
