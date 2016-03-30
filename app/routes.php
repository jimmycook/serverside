<?php

use App\Models\Listing;
use App\Models\Order;
use App\Models\User;
use App\Services\Auth;
use App\Services\Database;
use App\Services\Password;
use App\Services\Request;
use App\Services\Session;
use App\Views\View;

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


// Routes at the /api/* uri
$router->group(['prefix' => 'api'], function($router){

    // Get the listing details from the API
    $router->get('listings/{slug:c}', function ($slug) {
        $listing = Listing::findSlug($slug);

        if (!$listing)
        {
            return false;
        }

        return json_encode($listing);
    });

    // Delete listings
    $router->post('delete', function () {
        $request = new Request;

        $listing = Listing::findSlug($request->post('slug'));
        if ($listing && check())
        {
            $user = user();
            if ($user['id'] == $listing['user_id'])
            {
                return Listing::delete($listing['id']);
            }
        }
        return false;
    });

    $router->post('complete', function () {
        $request = new Request;
        return Order::complete($request->post('id'));

    });

});
