<?php

namespace App\Controllers;

use App\Views\View;
use App\Services\Request;
use App\Models\User;

class AccountController
{
    /**
     * Home page response
     * @return String response
     */
    public function anyIndex()
    {
        $user = user();

        return View::render('/pages/account', ['user' => $user]);
    }

    public function postAddfunds()
    {
        $request = new Request();
        $value = ($request->post('pounds') * 100) + $request->post('pence');
        $user = user();
        User::updateCredit($user['id'], '+', $value);
        flash('Your credit has been updated!');
        redirect('/account/');
    }

}
