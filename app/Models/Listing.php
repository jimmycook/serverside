<?php

namespace App\Models;

use App\Services\Database;

class Listing
{

    protected $table = 'listings';

    public static function findSlug($slug)
    {
        $query = 'SELECT * FROM listings WHERE slug = :slug';
        $result = Database::getInstance()->query($query, ['slug' => $slug]);

        if ($result)
        {
            $listing = $result[0];

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
        // $sql = 'INSERT INTO ' . self::$table . ' VALUES ()'
    }

    public static function getUserListings(array $user)
    {
        $query = 'SELECT * FROM listings WHERE user_id = :user_id';
        $result = Database::getInstance()->query($query, ['user_id' => $user['id']]);

        foreach($result as $key => $listing)
        {
            $listing['order'] = Order::getForListing($listing['id']);
            $result[$key] = $listing;
        }
        
        if(count($result))
        {
            return $result;
        }
        return [];
    }

}
