<?php


namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;


use App\Models\User;
use App\Models\UserRole;
use App\Models\Role;
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

        log_message('info', 'SubscriberFilter: Checking if user is a subscriber.');

        $session = AuthHelper::validateSession();

        log_message('info', 'SubscriberFilter: Session validation result: ' . ($session ? 'valid' : 'invalid'));
        if (!$session) {
            session()->setFlashdata('error', 'Din session har gått ut.');
            session()->remove('session_token');
            session()->remove('user_id');
            return redirect()->to('/login');
        }
        // Check if the user is a subscriber
        $userId = session('user_id');
        $userModel = new User();
        $userRoleModel = new UserRole();
        $roleModel = new Role();
        
        //fetch all roles for the user
        $user = $userModel->where('id', $userId)->first();
        $userRoles = $userRoleModel->where('user_id', $userId)->findAll();

        $roleIds = array_column($userRoles, 'role_id');

        $rolesResult = $roleModel->whereIn('id', $roleIds)->findAll();
        $roleNames = array_column($rolesResult, 'name');




        // Check if the user is a subscriber
        if (!$user || !in_array('subscriber', $roleNames)) {
            session()->setFlashdata('error', 'Du måste vara inloggad som prenumerant för att se denna sida.');
            session()->remove('session_token');
            session()->remove('user_id');
            return redirect()->to('/login');
        }

        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something after the request
    }

}