<?php

namespace App\Services;

use App\Models\User;
use App\Services\Auth;

class Auth
{

    public static function login($username, $password)
    {
        $user = User::getByUsername($username, $password);
        if($user)
        {
            if(Password::check($password, $user['password']))
            {
                self::setLoggedIn($user);
                return true;
            }
        }

        return false;

    }

    public static function check()
    {
        if (Session::get('authenticated_user'))
        {
            return true;
        }
        return false;
    }

    public static function user()
    {
        if (Session::get('authenticated_user'))
        {
            return User::find(Session::get('authenticated_user'));
        }
        throw new \App\Services\Exceptions\NotAuthenticatedException;
    }

    private static function setLoggedIn($user)
    {
        if (isset($user['id']))
        {
            Session::set('authenticated_user', $user['id']);
        }
    }

    public static function logout()
    {
        if (Session::get('authenticated_user'))
        {
            Session::destroy('authenticated_user');
        }
    }
}
