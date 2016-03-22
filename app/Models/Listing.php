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
            return $result[0];
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

}
