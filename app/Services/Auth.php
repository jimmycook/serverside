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
                return true;
            }
        }
        return false;

    }

    public static function logout()
    {
        // Check login status
        //
        // If not logged in return redirect
        //
        //
    }

    public static function check()
    {
        // Check if the user is currently logged in at all to a valid user ID
    }

    public static function user()
    {
        // return the currently authetnicated user object
    }
}
