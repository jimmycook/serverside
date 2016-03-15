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

$router->any('test', function () {

});
