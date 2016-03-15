<?php

namespace App\Controllers;

use App\Views\View;
use App\Services\Request;
use App\Services\Auth;
use App\Services\Password;
use App\Models\User;

class PagesController
{

    public function __construct()
    {
        // $this->request = new Request();
    }

    public function anyIndex()
    {
        return View::render('prototype');
    }

    public function getLogin()
    {
        if(Auth::check())
        {
            redirect('/account/');
        }
        return View::render('pages/login');
    }

    public function postLogin()
    {
        if(Auth::check())
        {
            redirect('/account/');
        }

        $request = new Request();

        $username = $request->post('username');
        $password = $request->post('password');

        if(Auth::login($username, $password))
        {
            redirect('/account');
        }

        flash('Your login details were incorrect.');
        return View::render('pages/login');


    }

    public function anyLogout()
    {
        Auth::logout();
        redirect('/');
    }

    public function getRegister()
    {
        if(Auth::check())
        {
            redirect('/account');
        }

        return View::render('pages/register');
    }

    public function postRegister()
    {
        if(Auth::check())
        {
            redirect('/account/');
        }

        $request = new Request();

        $password = $request->post('password');

        $new['username'] = $request->post('username');
        $new['password'] = Password::hash($password);
        $new['first_name'] = $request->post('first_name');
        $new['last_name'] = $request->post('last_name');
        $new['email'] = $request->post('email');
        $new['seller'] = 0;
        $new['credit'] = 0;

        User::create($new);

        if (Auth::login($new['username'], $password))
        {
            redirect('/account');
        }
        else
        {
            flash('There was a problem with your sign up. There username or
             email you are trying to sign up with may already have been used.
              Please try again.');
            redirect($_SERVER['HTTP_REFERER']);
        }


    }

}
