<?php

namespace App\Services;

use App\Models\User;
use App\Services\Auth;

class Auth
{

    /**
     * Log a user in
     * @param  string $username
     * @param  string $password
     * @return boolean
     */
    public static function login($username, $password)
    {
        $user = User::getByUsername($username, $password);

        if ($user)
        {
            if(Password::check($password, $user['password']))
            {
                self::setLoggedIn($user);
                return true;
            }
        }

        return false;

    }

    /**
     * Check if somebody is logged in
     * @return boolean
     */
    public static function check()
    {
        if (Session::get('authenticated_user'))
        {
            return true;
        }
        return false;
    }

    /**
     * Get the logged in user array
     * @return array|boolean
     */
    public static function user()
    {
        if (Session::get('authenticated_user'))
        {
            return User::find(Session::get('authenticated_user'));
        }
        return false;
    }

    /**
     * Set the logged in user
     * @param array $user
     * @return void
     */
    private static function setLoggedIn($user)
    {
        if (isset($user['id']))
        {
            Session::set('authenticated_user', $user['id']);
        }
    }

    /**
     * Log a user out
     * @return void
     */
    public static function logout()
    {
        if (Session::get('authenticated_user'))
        {
            Session::destroy('authenticated_user');
        }
    }
}
