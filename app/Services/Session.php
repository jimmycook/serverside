<?php

namespace App\Services;

class Session
{

    /**
     * Start the session
     * @return void
     */
    public static function start()
    {
        session_start();
    }

    /**
     * Set a variable to the Session
     * @param string $key
     * @param string $value
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get an item from the session
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public static function get($key, $default = false)
    {
        if(isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * Remove an item from the session
     * @param  string $key
     * @return mixed
     */
    public static function destroy($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Destroy the session
     * @return [type] [description]
     */
    public static function destroyAll()
    {
        session_destroy();
    }

}
