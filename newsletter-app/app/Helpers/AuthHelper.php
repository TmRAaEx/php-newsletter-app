<?php


namespace App\Helpers;
use App\Models\User;
use App\Models\Session;

/**
 * AuthHelper This helper class provides methods to check if a user is logged in and to validate the session token.
 */
class AuthHelper
{
    public static function isLoggedIn()
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
        
        return $session ?? false;    
    }
}