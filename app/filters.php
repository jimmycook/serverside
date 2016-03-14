<?php

use App\Services\Auth;

$router->filter('check', function() {
    if(!Auth::check())
    {
        redirect('login');
    }
});

$router->filter('checkSeller', function() {

});
