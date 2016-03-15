<?php

namespace App\Services;

use SessionHandler;

class Session
{

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }


    public static function get($key, $default = false)
    {
        if(isset($_SESSION[$key]))
            return $_SESSION[$key];
        return $default;
    }

    public static function destroy($key)
    {
        unset($_SESSION[$key]);
    }

    public static function destroyAll()
    {
        session_destroy();
    }

}
