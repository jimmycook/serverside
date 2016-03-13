<?php

namespace App\Controllers;

use App\Views\View;
use App\Services\Request;
use App\Services\Auth;

class PagesController
{

    public function anyIndex()
    {
        return View::render('prototype');
    }

    public function getLogin()
    {
        return View::render('pages/login');
    }

    public function postLogin()
    {
        $request = new Request();

        $username = $request->post('username');
        $password = $request->post('password');
        
        dd(Auth::login($username, $password));

        return 'postLogin';
    }

    public function getRegister()
    {
        return 'register';
    }

}
