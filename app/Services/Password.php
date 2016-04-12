<?php

namespace App\Services;

class Password
{
    /**
     * Hash a password
     * @param  string $password
     * @return string
     */
    public static function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Check a password
     * @param  string $password
     * @param  string $hash
     * @return boolean
     */
    public static function check($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
