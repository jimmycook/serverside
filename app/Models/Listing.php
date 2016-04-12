<?php

namespace App\Models;

use App\Models\Order;
use App\Models\User;
use App\Services\Database;
use App\Services\Request;
use App\Services\File;
use Carbon\Carbon;

class Listing extends Model
{
    /**
     * The database table for the resource
     * @var string
     */
    protected static $table = 'listings';

    /**
     * Find a specific listing
     * @param  int $id
     * @return mixed
     */
    public static function find($id)
    {
        $query = "SELECT * FROM " . self::$table . " WHERE id = :id;";
        $result = Database::getInstance()->query($query, ['id' => $id]);

        if(count($result))
        {
            $listing = $result[0];
            $listing['user'] = User::find($listing['user_id']);
            $listing['order'] = Order::getForListing($listing['id']);
            $listing['category'] = Category::find($listing['user_id']);
            return $listing;
        }

        return false;
    }

    /**
     * Find a listing by the slug
     * @param  string $slug
     * @return mixed
     */
    public static function findSlug($slug, $activeOnly = true)
    {
        $query = 'SELECT * FROM listings WHERE slug = :slug';
        $result = Database::getInstance()->query($query, ['slug' => $slug]);

        if ($result)
        {
            $listing = $result[0];
            $listing['user'] = User::find($listing['user_id']);
            $listing['order'] = Order::getForListing($listing['id']);
            $listing['category'] = Category::find($listing['user_id']);
            return $listing;
        }
        else
        {
            return false;
        }
    }

    /**
     * Create a listing
     * @param  array $params
     * @return boolean
     */
    public static function create($params)
    {
        $now = date("Y-m-d H:i:s");
        $query = "INSERT INTO " . self::$table . "(id, user_id, created_at, paid_until, name, slug, description, price, img_path, category_id, active)
        VALUES (NULL, :user_id, '$now', '$now', :name, :slug, :description, :price, :img_path, :category_id, 1);";

        Database::getInstance()->query($query, $params);
        return true;
    }

    /**
     * Delete a listing
     * @param  int $id
     * @return boolean
     */
    public static function delete($id)
    {
        Order::deleteForListing($id);
        $sql = 'DELETE FROM ' . self::$table . ' WHERE id = :id';
        $result = Database::getInstance()->query($sql, ['id' => $id]);
        return true;
    }

    /**
     * Activate a listing
     * @param  int $id
     * @return boolean
     */
    public static function activate($id)
    {
        $sql = 'UPDATE ' . self::$table . ' SET active = true WHERE id = :id';
        $result = Database::getInstance()->query($sql, ['id' => $id]);
        return true;
    }

    /**
     * Deactivate a listing
     * @param  int $id
     * @return boolean
     */
    public static function deactivate($id)
    {
        $sql = 'UPDATE ' . self::$table . ' SET active = false WHERE id = :id';
        $result = Database::getInstance()->query($sql, ['id' => $id]);
        return true;
    }

    /**
     * Get a user's listing
     * @param  array  $user
     * @param boolean $activeOnly
     * @return array
     */
    public static function getUserListings($user, $activeOnly = false)
    {
        if (user() == $user) {
            $query = 'SELECT * FROM ' . self::$table . ' WHERE user_id = :user_id ORDER BY created_at';
            $result = Database::getInstance()->query($query, ['user_id' => $user['id']]);

            if($result)
            {
                foreach($result as $key => $listing)
                {
                    $listing['order'] = Order::getForListing($listing['id']);
                    $listing['user'] = User::find($listing['user_id']);
                    $listing['category'] = Category::find($listing['user_id']);
                    $result[$key] = $listing;
                }

                return $result;
            }
            return [];
        }
    }

    /**
     * Get the four most recent listings
     * @param int $limit
     * @param boolean $activeOnly
     * @return array
     */
    public static function getRecent($activeOnly = true)
    {
        $query = 'SELECT * FROM ' . self::$table . ' ORDER BY created_at LIMIT 4';

        if ($activeOnly)
        {
            $query = 'SELECT * FROM ' . self::$table . ' WHERE active = true ORDER BY created_at LIMIT 4';
        }

        $result =  Database::getInstance()->query($query);

        return self::filterSold($result);
    }

    /**
     * Get all of the listings in the system
     * @param boolean $activeOnly
     * @return array
     */
    public static function getAll($activeOnly = true)
    {
        $query = 'SELECT * FROM ' . self::$table;
        if ($activeOnly)
        {
            $query = 'SELECT * FROM ' . self::$table . ' WHERE active = true';
        }
        return Database::getInstance()->query($query);
    }

    /**
     * Return all of the entries for a specific category
     * @param  int    $id category id
     * @param boolean $activeOnly
     * @return mixed
     */
    public static function getForCategory($id, $activeOnly = true)
    {
        $query = 'SELECT * FROM ' . self::$table . ' WHERE category_id = :category_id';
        if ($activeOnly)
        {
            $query = 'SELECT * FROM ' . self::$table . ' WHERE category_id = :category_id AND active = true';
        }

        $result =  Database::getInstance()->query($query, ['category_id' => $id]);

        return self::filterSold($result);
    }

    /**
     * Set the paid until date
     * @param Carbon $date
     */
    public static function setPaidUntil($id, Carbon $date)
    {
        $query = "UPDATE ".self::$table." SET paid_until = :date WHERE id = :id";
        return Database::getInstance()->query($query, ['id' => $id, 'date' => $date->__toString()]);
    }

    /**
     * Filter out sold listings
     * @param  array $result
     * @return array
     */
    public static function filterSold($result)
    {
        if (count($result) && is_array($result))
        {
            foreach ($result as $key => $listing)
            {
                if (is_array(Order::getForListing($listing['id'])))
                {
                    unset($result[$key]);
                }
            }
        }

        if (count($result))
        {
            return $result;
        }

        return false;
    }

}
