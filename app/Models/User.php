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

    public static function create($details)
    {
        $query = "INSERT INTO " . self::$table ." VALUES
            (null, :username, :password, :first_name, :last_name, :email, :credit, :seller);";

        $result = Database::getInstance()->query($query, $details);
    }

    public static function usernameExists($username, $email)
    {
        $query = "SELECT * FROM $this->table WHERE username = $username OR email = $email;";
        $database = Database::getInstance();
        return count($result);
    }

    public static function getAll()
    {
        $query = 'SELECT * FROM ' . self::$table;
        $result = Database::getInstance()->query($query);

        if (count($result))
        {
            return $result;
        }

        return null;
    }

    public static function find($id)
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

}
