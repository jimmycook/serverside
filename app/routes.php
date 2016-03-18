<?php

use App\Views\View;
use App\Services\Database;
use App\Services\Password;
use App\Services\Auth;
use App\Services\Session;
use App\Models\User;

$router->controller('/', 'App\\Controllers\\PagesController');

$router->controller('account', 'App\\Controllers\\AccountController', ['before' => 'check']);

$router->controller('sell', 'App\\Controllers\\AccountController', ['before' => 'checkSeller']);

$router->get('listings/{slug:c}', function ($slug) {
    $params = [];
    $params['listing'] = [
        'id' => 1,
        'name' => 'Gibson Custom Shop 1959 Les Paul Reissue VOS 2013 in Lemon Burst',
        'description' => 'The Gibson Les Paul LPR9 1959 Reissue Les Paul VOS (Vintage Original Specification) is a true joy to behold: Gibson have pulled out all the stops to recreate this Les Paul Standard closer than ever before to the 635 guitars they shipped in 1959. New features for 2013 include period correct Aniline dye finishes, hot hide glue neck joins, historic no-tubing truss rod assembly and Kluson deluxe machine heads. Perhaps the biggest step towards the original tone of the 1959 Les Paul Standard however is the new Custom Bucker which is painfully recreated from an original late 50s PAF (Patent Applied For) Humbucker. Thanks in part to the Bumble Bee tone cap the LPR9 sings beautifully at full volume and when rolled off has a distinct creamy character that cleans up stunningly.',
        'price' => '600000',
        'img_path' => 'http://content.andertons.co.uk/2/1/images/catalog/i/xxld_16219-LPR93VOLBNH1_super.jpg',

    ];

    return View::render('pages/listing', $params);
});

$router->any('test', function () {
    if(check())
    {
        return 'logged in';
    }
    else
    {
        return 'not logged in';
    }
});
