<?php

namespace App\Controllers;

use App\Views\View;

class AccountController
{
    /**
     * Home page response
     * @return String response
     */
    public function anyIndex()
    {
        return View::render('/pages/account');
    }

    public function anyAddfunds()
    {
        return 'add funds page';
    }

}
