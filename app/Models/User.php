<?php

namespace App\Models;

use App\Services\Database;

class User extends Model
{

    protected static $table = 'users';

    public function __construct($attributes = [])
    {
        foreach($attributes as $key => $attri)
        {
            $this->{$key} = $attri;
        }
    }

    public static function create($username, $password, $email, $firstName, $lastName, $seller = 0, $credit = 0)
    {

        $query = "INSERT INTO users VALUES (null, $username, password, $firstName, $lastName, $email, $credit, $seller)";
    }

    public static function usernameExists($username, $email)
    {
        $query = "SELECT * FROM $this->table WHERE username = $username OR email = $email;";
        $database = Database::getInstance();
        dd($database);
        return count($result);
    }

    public static function getAll()
    {
        $query = 'SELECT * FROM ' . self::$table;
        $result = Database::getInstance()->query($query);
        if (count($result))
            return $result;
        return null;
    }

    public static function getByID($id)
    {
        $query = "SELECT * FROM " . self::$table . " WHERE id = $id;";
        $result = Database::getInstance()->query($query);
        if(count($result))
        {
            return $result[0];
        }
        return false;
    }

    public static function getByUsername($username)
    {
        $query = "SELECT * FROM " . self::$table . " WHERE username = '$username';";
        $result = Database::getInstance()->query($query);
        if(count($result))
        {
            return $result[0];
        }
        return false;
    }

    /**
     * Convert the result of a query into User objects
     */
    public static function convert($array)
    {
        dd($array);
    }
}
