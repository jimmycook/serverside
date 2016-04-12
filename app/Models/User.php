<?php

namespace App\Models;

use App\Services\Database;

class User extends Model
{

    protected static $table = 'users';

    /**
     * Create a new user in the database
     * @param  array  $details
     * @return void
     */
    public static function create($details)
    {
        $query = "INSERT INTO " . self::$table ." VALUES
            (null, :username, :password, :first_name, :last_name, :email, :credit, :seller);";

        $result = Database::getInstance()->query($query, $details);
    }

    /**
     * Check a username within the system
     * @param  string $username
     * @param  string $email
     * @return mixed
     */
    public static function usernameExists($username, $email)
    {
        $query = "SELECT * FROM $this->table WHERE username = $username OR email = $email;";
        $database = Database::getInstance();
        return count($result);
    }

    /**
     * Get all users
     * @return array|boolean
     */
    public static function getAll()
    {
        $query = 'SELECT * FROM ' . self::$table;
        $result = Database::getInstance()->query($query);

        if (count($result))
        {
            return $result;
        }

        return false;
    }

    /**
     * Find a user by their id
     * @param  int $id
     * @return array|boolean
     */
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

    /**
     * Charge a user
     * @param  int    $id
     * @param  int    $amount
     * @return mixed
     */
    public static function charge($id, $amount)
    {
        $user = self::find($id);

        // Check the user was returned
        if($user)
        {
            // Check they can be charged
            $newCredit = $user['credit'] - $amount;
            if ($newCredit >= 0)
            {
                // Charge
                $query = "UPDATE users SET credit = $newCredit WHERE id = :id";
                $result = Database::getInstance()->query($query, ['id' => $id]);
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Credit a user
     * @param  int $id
     * @param  int $amount
     * @return boolean
     */
    public static function credit($id, $amount)
    {
        $user = self::find($id);

        if($user)
        {
            $newCredit = $user['credit'] + $amount;
            $query = "UPDATE users SET credit = $newCredit WHERE id = :id";
            $result = Database::getInstance()->query($query, ['id' => $id]);
            return true;
        }
        return false;
    }

    /**
     * Refund an order
     * @param  array  $order
     * @return mixed
     */
    public static function refund($order)
    {
        $user = self::find($order['user_id']);
        $listing = Listing::find($order['listing_id']);

        if ($order['status'] == 'processing')
        {
            $query = "UPDATE users SET credit = " . ($user['credit'] + $listing['price'])
             . " WHERE id = " . $user['id'] . ";";
            $result = Database::getInstance()->query($query);
        }
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

    public static function updateCredit($id, $operator, $value)
    {
        $query = "UPDATE users SET credit = (credit $operator $value) WHERE id = :id;";
        $result = Database::getInstance()->query($query, ['id' => $id]);
        if(count($result))
        {
            return $result[0];
        }
        return false;
    }

}
