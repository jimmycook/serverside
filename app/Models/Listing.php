<?php

namespace App\Models;

use App\Models\Order;
use App\Models\User;
use App\Services\Database;
use App\Services\Request;
use App\Services\File;

class Listing
{

    protected static $table = 'listings';

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

    public static function findSlug($slug)
    {
        $query = 'SELECT * FROM listings WHERE slug = :slug';
        $result = Database::getInstance()->query($query, ['slug' => $slug]);

        if ($result)
        {
            $listing = $result[0];
            $listing['user'] = User::find($listing['user_id']);
            $listing['order'] = Order::getForListing($listing['id']);
            return $listing;
        }
        else
        {
            return false;
        }
    }

    public static function create($params)
    {
        $now = date("Y-m-d H:i:s");
        $query = "INSERT INTO " . self::$table . "(id, user_id, created_at, paid_until, name, slug, description, price, img_path)
        VALUES (NULL, :user_id, '$now', '$now', :name, :slug, :description, :price, :img_path);";
        dd($params);
        dd(Database::getInstance()->query($query, $params));
        return true;
    }

    public static function delete($id)
    {
        $sql = 'DELETE FROM ' . self::$table . ' WHERE id = :id';
        $result = Database::getInstance()->query($sql, ['id' => $id]);
        return true;
    }

    public static function getUserListings(array $user)
    {
        if (user() == $user) {
            $query = 'SELECT * FROM listings WHERE user_id = :user_id';
            $result = Database::getInstance()->query($query, ['user_id' => $user['id']]);

            if($result)
            {
                foreach($result as $key => $listing)
                {
                    $listing['order'] = Order::getForListing($listing['id']);
                    $listing['user'] = User::find($listing['user_id']);
                    $result[$key] = $listing;
                }

                return $result;
            }
            return [];
        }
    }

}
