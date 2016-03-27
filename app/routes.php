<?php

use App\Views\View;
use App\Services\Database;
use App\Services\Password;
use App\Services\Auth;
use App\Services\Session;
use App\Models\User;
use App\Models\Listing;

$router->controller('/', 'App\\Controllers\\PagesController');

$router->controller('account', 'App\\Controllers\\AccountController', ['before' => 'check']);

/**
 * Show a specific listing
 */
$router->get('listings/{slug:c}', function ($slug) {
    $listing = Listing::findSlug($slug);

    if (!$listing)
    {
        throw new Phroute\Phroute\Exception\HttpRouteNotFoundException('404', 1);
    }

    $params['user'] = User::find($listing['user_id']);
    $params['listing'] = $listing;

    return View::render('pages/listing', $params);
});

/**
 * Start the order process
 */
$router->post('listings/{slug:c}', function ($slug) {

    if (!check())
    {
        flashURL("listings/$slug");
        redirect('/login');
    }
});


$router->group(['before' => 'auth', 'prefix' => 'api'], function($router){
    /**
     * Api request for the listing
     */
    $router->get('listings/{slug:c}', function ($slug) {
        $listing = Listing::findSlug($slug);

        if (!$listing)
        {
            return false;
        }

        return json_encode($listing);
    });


});

$router->any('test', function () {

});
