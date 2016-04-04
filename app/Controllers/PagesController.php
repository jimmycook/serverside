<?php

namespace App\Controllers;

use App\Services\Password;
use App\Services\Request;
use App\Services\Auth;
use App\Models\User;
use App\Models\Listing;
use App\Models\Category;
use App\Views\View;

class PagesController
{

    /**
     * Serve the homepage
     * @return string view
     */
    public function anyIndex()
    {
        $categories = Category::getAll();
        $recent = Listing::getRecent();
        //  @TODO fix this
        foreach ($categories as $key => $category) {
            if (is_array($category['listings']))
            {
                $category['listings'] = array_slice($category['listings'], 0 , 4);
                $categories[$key] = $category;
            }
        }

        return View::render('pages/home', [
            'recent' => $recent,
            'categories' => $categories,
        ]);
    }

    /**
     * server the categories page
     * @return string view
     */
    public function anyCategories()
    {
        $categories = Category::getAll();

        foreach ($categories as $key => $category) {
            if (is_array($category['listings']))
            {
                $category['listings'] = array_slice($category['listings'], 0 , 4);
                $categories[$key] = $category;
            }
        }

        return View::render('pages/categories', [
            'categories' => $categories,
        ]);
    }

    /**
     * Serve the login page
     * @return string
     */
    public function getLogin()
    {

        if(Auth::check())
        {
            if(!goToFlashUrl())
            {
                redirect('/account');
            }
        }

        return View::render('pages/login');
    }

    /**
     * Handle the login form being submitted.
     *
     * @return string the view if the login fails
     */
    public function postLogin()
    {

        if (Auth::check())
        {
            redirect('/account/');
        }

        $request = new Request();

        $username = $request->post('username');
        $password = $request->post('password');

        $loggedIn = Auth::login($username, $password);

        if ($loggedIn)
        {
            if(!goToFlashUrl())
            {
                redirect('/account');
            }
        }

        flash('Your login details were incorrect.');
        return View::render('pages/login');
    }

    /**
     * Log the user out
     * @return redirect
     */
    public function anyLogout()
    {
        Auth::logout();
        redirect('/');
    }

    /**
     * Display the registration form
     *
     * @return void
     */
    public function getRegister()
    {
        if(Auth::check())
        {
            redirect('/account');
        }

        return View::render('pages/register');
    }

    /**
     * Handle the registration form being submitted
     *
     * Will call a redirect
     *
     * @return void
     */
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
            if(!goToFlashUrl())
            {
                redirect('/account');
            }
        }
        else
        {
            flash('There was a problem with your registration. There username or
             email you are trying to sign up with may already have been used.
              Please try again.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
