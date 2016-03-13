<?php

namespace App\Services;

class Request
{
    public function get($key)
    {
        if(isset($_GET[$key]))
        {
            return $_GET[$key];
        }
    }

    public function post($key)
    {
        if(isset($_POST[$key]))
        {
            return $_POST[$key];
        }
    }
}
