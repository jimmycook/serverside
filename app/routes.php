<?php

use Framework\Routing\Router;

Router::get('hello', function() {
	return 'hello the router works';
});