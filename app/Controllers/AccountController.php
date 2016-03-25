<?php

namespace App\Controllers;

use App\Views\View;
use App\Services\Request;
use App\Models\User;
use App\Models\Listing;

class AccountController
{
    /**
     * Home page response
     * @return String response
     */
    public function anyIndex()
    {
        $user = user();

        $listings = Listing::getUserListings($user);

        return View::render('/pages/account', ['user' => $user, 'listings' => $listings]);
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
