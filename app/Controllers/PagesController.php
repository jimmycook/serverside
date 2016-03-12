<?php

namespace App\Controllers;

use App\Views\View;

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
        return 'postLogin';
    }

    public function getRegister()
    {
        return 'register';
    }

}
