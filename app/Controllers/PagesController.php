<?php

namespace App\Controllers;

use App\Views\View;

class PagesController
{

    /**
     * Home page response
     * @return String response
     */
    public function anyIndex()
    {
        return View::render('prototype');
    }
}
