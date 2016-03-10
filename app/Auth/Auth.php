<?php

namespace App\Auth;

class Auth
{
    
    public function login($username, $password)
    {

        // Query for username
        //
        // Check if it was returned
        //
        // Check password
        //
        // Return view

    }

    public function logout()
    {
        // Check login status
        //
        // If not logged in return redirect
        //
        //
    }

    public function check()
    {
        // Check if the user is currently logged in at all to a valid user ID
    }

    public function user()
    {
        // return the currently authetnicated user object
    }
}
