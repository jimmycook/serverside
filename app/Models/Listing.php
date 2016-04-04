<?php

namespace App\Models;

use App\Models\Order;
use App\Models\User;
use App\Services\Database;
use App\Services\Request;
use App\Services\File;

class Listing
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
     * Find a lisitng by the slug
     * @param  string $slug
     * @return mixed
     */
    public static function findSlug(string $slug)
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
    public static function create(array $params)
    {
        $now = date("Y-m-d H:i:s");
        $query = "INSERT INTO " . self::$table . "(id, user_id, created_at, paid_until, name, slug, description, price, img_path, category_id)
        VALUES (NULL, :user_id, '$now', '$now', :name, :slug, :description, :price, :img_path, :category_id);";

        Database::getInstance()->query($query, $params);
        return true;
    }

    /**
     * Delete a listing
     * @param  int $id
     * @return boolean
     */
    public static function delete(int $id)
    {
        $sql = 'DELETE FROM ' . self::$table . ' WHERE id = :id';
        $result = Database::getInstance()->query($sql, ['id' => $id]);
        return true;
    }

    /**
     * Get a user's listing
     * @param  array  $user
     * @return array
     */
    public static function getUserListings(array $user)
    {
        if (user() == $user) {
            $query = 'SELECT * FROM ' . self::$table . ' WHERE user_id = :user_id';
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
     * Get recent listings
     * @param  integer $limit The number of listings
     * @return array
     */
    public static function getRecent(int $limit = 4)
    {
        $query = 'SELECT * FROM ' . self::$table . ' ORDER BY created_at LIMITED :limit;';
        return Database::getInstance()->query($query, ['limit' => $limit]);
    }

    /**
     * Return all of the entries for a specific category
     * @param  int    $id category id
     * @return mixed
     */
    public static function getForCategory(int $id)
    {
        $query = 'SELECT * FROM ' . self::$table . ' WHERE category_id = :category_id';
        return Database::getInstance()->query($query, ['category_id' => $id]);
    }

}
