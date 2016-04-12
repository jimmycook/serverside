<?php

namespace App\Services;
use Carbon\Carbon;

class Cookie
{

    /**
     * [set description]
     * @param string $name
     * @param mixed $value
     * @param Carbon\Carbon $time
     */
    public static function set($name, $value, Carbon $time = null)
    {
        if (is_null($time))
        {
            $time = Carbon::now()->addHour();
        }

        setcookie($name, $value, $time->timestamp);
    }

    /**
     * Get a value from a cookie
     * @param  string $name
     * @return mixed
     */
    public static function get($name)
    {
        if (isset($_COOKIE[$name]))
        {
            return $_COOKIE[$name];
        }
        return false;
    }
}
