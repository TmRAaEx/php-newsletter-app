<?php


namespace App\Helpers;
use App\Models\Session;

/**
 * AuthHelper This helper class provides methods to check if a user is logged in and to validate the session token.
 */
class AuthHelper
{
    public static function validateSession()
    {
        $sessionToken = session('session_token');
        $userId = session('user_id');

        if (!$sessionToken || !$userId) {
            return false;
        }

        // Check if the session token is valid
        $sessionModel = new Session();

        // delete expired sessions
        //TODO: Move this to a cron job
        $sessionModel->where('expires_at <', date('Y-m-d H:i:s'))->delete();

        $session = $sessionModel
            ->where('session_token', $sessionToken)
            ->where('user_id', $userId)
            ->where('expires_at >=', date('Y-m-d H:i:s'))
            ->first();

        if (!$session) {
            return false;
        }

        // If the session is valid, refresh the session expiration time
        $sessionModel->builder()
            ->where('session_token', $sessionToken)
            ->where('user_id', $userId)
            ->update(['expires_at' => date('Y-m-d H:i:s', strtotime('+30 days'))]);


        return true;
    }

    public static function logout()
    {
        $sessionModel = new Session();
        $sessionToken = session('session_token');
        $userId = session('user_id');

        // Delete the session from the database
        $sessionModel->where('session_token', $sessionToken)
            ->where('user_id', $userId)
            ->delete();

        // Destroy the session
        session()->destroy();
    }

    public static function logOutAll()
    {
        $sessionModel = new Session();
        $userId = session('user_id');

        // Delete all sessions for the user
        $sessionModel->where('user_id', $userId)->delete();

        // Destroy the session
        session()->destroy();
    }
}