<?php

namespace App\Controllers;

use App\Views\View;
use App\Services\Request;
use App\Services\File;
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
        // Sort the array
        usort($listings, function ($a1, $a2) {
            $v1 = strtotime($a1['created_at']);
            $v2 = strtotime($a2['created_at']);
            return $v1 - $v2;
        });
        return View::render('/pages/account', ['user' => $user, 'listings' => $listings]);
    }

    public function postAddfunds()
    {
        $request = new Request();
        $value = ($request->post('pounds') * 100) + $request->post('pence');
        $user = user();
        if ($value > 0){
            User::updateCredit($user['id'], '+', $value);
            flash('Your credit has been updated!');
        }
        else
        {
            flash('Your credit has not been updated because you entered a negative value. Please try again.');

        }
        redirect('/account/');
    }

    public function postWithdrawfunds()
    {
        $request = new Request();
        $value = ($request->post('pounds') * 100) + $request->post('pence');
        $user = user();
        if ($value > 0){
            User::updateCredit($user['id'], '-', $value);
            flash('Your credit has been withdrawn!');
        }
        else
        {
            flash('Your credit has not been withdrawn because you entered a negative value. Please try again.');

        }
        redirect('/account/');
    }

    public function postCreatelisting()
    {
        $request = new Request();

        $params = [];
        $user = user();
        $params['user_id'] = $user['id'];
        $params['name'] = $request->post('name');
        $params['slug'] = slugify($request->post('name'));
        $params['description'] = $request->post('description');
        $params['price'] = $request->post('pounds') * 100 + $request->post('pence');

        if($params['price'] < 0 || $request->post('pence') < 0) {
            flash('Your listing creation failed, the price cannot be negative. Please try again.');
            redirect('/account/');
        }

        // This commented code was for File uploads but I decided to ditch them for
        // just urls instead to save time.
        // Image handling
        // $imageType = $request->post('image-type');
        // if ($imageType == 'image-file')
        // {
        //     if(File::saveIfImage('/images/listings/' . $params['slug']))
        //     {
        //
        //     }
        // }
        // else if ($imageType == 'image-url')
        // {
            $params['img_path'] = $request->post('image-url');
        // }

        $params['img_path'] = $request->post('image-url');


        foreach($params as $p)
        {
            if ($p == "")
            {
                flash('Your listing creation failed, there was an emptry field. Please try again.');
                retdirect('/account/');
            }
        }

        // Query the database
        Listing::create($params);
        flash('Your listing creation was successful!');
        redirect('/account/');

    }

}
