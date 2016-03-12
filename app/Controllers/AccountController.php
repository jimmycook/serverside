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
        return 'account loads';
    }

    public function anyAddfunds()
    {
        return 'add funds page';
    }

}
