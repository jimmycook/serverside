<?php

use App\Models\Listing;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Services\Auth;
use App\Services\Database;
use App\Services\Password;
use App\Services\Paginator;
use App\Services\Request;
use App\Services\Session;
use App\Views\View;

$router->controller('/', 'App\\Controllers\\PagesController');

$router->controller('account', 'App\\Controllers\\AccountController', ['before' => 'check']);

/**
 * Show a specific listing
 * @return string
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
 * Show a specific category
 * @return string
 */
$router->get('category/{slug:c}', function ($slug) {
    $category = Category::findSlug($slug);

    if (!$category)
    {
        throw new Phroute\Phroute\Exception\HttpRouteNotFoundException('404', 1);
    }

    $paginator = new Paginator($category['listings']);
    // Pagination
    $category['listings'] = $paginator->getPageArray();
    $page = $paginator->getPage();
    $numPages = $paginator->getNumPages();
    return View::render('pages/category', ['category' => $category, 'page' => $page, 'numPages' => $numPages]);
});


// Auth Check routes
$router->group(['before' => 'check'], function($router) {

    /**
     * Start the order process
     * @return view
     */
    $router->get('listings/order/{slug:c}', function ($slug) {
        $listing = Listing::findSlug($slug);
        $user = user();
        orderChecks($listing, $user);

        $params = [];
        $params['user'] = $user;
        $params['listing'] = $listing;

        return View::render('pages/order', $params);
    });

    /**
     * Finish the order
     */
    $router->post('listings/order/{slug:c}', function ($slug) {

        $request = new Request;
        $listing = Listing::findSlug($slug);
        $user = user();

        orderChecks($listing, $user);

        $params = [];
        $params['address'] = $request->post('address');
        $params['user_id'] = $user['id'];
        $params['listing_id'] = $listing['id'];
        $params['status'] = 'processing';

        if (Order::create($params))
        {
            $charged = User::charge($user['id'], $listing['price']);
            if ($charged)
            {
                User::credit($listing['user_id'], $listing['price']);
            }
            flash("Your order was created successfully, view it below.");
            redirect("/account/");
            die();
        }
        else
        {
            flash("Something went wrong, please try again.");
            redirect("/listings/" . $listing['slug']);
            die();
        }

    });

    // Routes at the /api/* uri, mostly for AJAX related actions on the site
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
        $router->post('listing/delete', function () {
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

        // Activate listings
        $router->post('listing/activate', function () {
            $request = new Request;

            $listing = Listing::findSlug($request->post('slug'));
            if ($listing && check())
            {
                $user = user();
                if ($user['id'] == $listing['user_id'])
                {
                    return Listing::activate($listing['id']);
                }
            }
            return false;
        });

        // Activate listings
        $router->post('listing/deactivate', function () {
            $request = new Request;

            $listing = Listing::findSlug($request->post('slug'));
            if ($listing && check())
            {
                $user = user();
                if ($user['id'] == $listing['user_id'])
                {
                    return Listing::deactivate($listing['id']);
                }
            }
            return false;
        });

        $router->post('order/complete', function () {
            $request = new Request;
            $user = user();
            $id = $request->post('id');
            $order = Order::findWithListing($id);
            // Check the user is correct
            if ($user['id'] == $order['user_id'])
            {
                return Order::complete($id);
            }
        });

        $router->post('order/cancel', function () {
            $request = new Request;
            $user = user();
            $id = $request->post('id');
            $order = Order::findWithListing($id);
            // Check the user is correct
            if ($user['id'] == $order['user_id'])
            {
                return Order::cancel($id);
            }
        });

    });

});

$router->any('test', function() {
    dd(Order::getForListing(9));
});
