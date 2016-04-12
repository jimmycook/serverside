<?php

namespace App\Services;

class Request
{
    /**
     * Get a get variable
     * @param  string $key
     * @return mixed
     */
    public function get($key)
    {
        if(isset($_GET[$key]))
        {
            return $_GET[$key];
        }
    }

    /**
     * Get a post variable from the Request
     * @param  string $key
     * @return mixed
     */
    public function post($key)
    {
        if(isset($_POST[$key]))
        {
            return $_POST[$key];
        }
    }
}
