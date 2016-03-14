<?php

namespace App\Controllers;

use App\Views\View;
use App\Services\Request;
use App\Services\Auth;

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
        else
        {
            $request = new Request();

            $username = $request->post('username');
            $password = $request->post('password');

            if(Auth::login($username, $password))
            {
                redirect('/account');
            }
            else
            {
                flash('Your login details were incorrect.');
                return View::render('pages/login');
            }
        }
        return 'postLogin';
    }

    public function anyLogout()
    {
        Auth::logout();
        redirect('/');
    }

    public function getRegister()
    {
        return View::render('pages/register');
    }

    public function postRegister()
    {
        return View::render('pages/register');
    }

}
