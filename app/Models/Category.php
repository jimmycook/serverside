<?php

namespace App\Models;

use App\Services\Database;
use App\Models\Listing;

class Category extends Model
{

    protected static $table = 'categories';

    /**
     * Find a specific item
     * @param  int    $id
     * @return mixed
     */
    public static function find(int $id)
    {
        $query = "SELECT * FROM " . self::$table . " WHERE id = :id;";
        $result = Database::getInstance()->query($query, ['id' => $id]);

        if(count($result))
        {
            return $result[0];
        }

        return false;
    }

    /**
     * Get all categories
     * @return mixed
     */
    public static function getAll()
    {
        $query = "SELECT * FROM " . self::$table . ";";
        $categories = Database::getInstance()->query($query);

        foreach ($categories as $key => $category) {
            $categories[$key]['listings'] = Listing::getForCategory($category['id']);
        }

        return $categories;
    }

    /**
     * Find a category by it's slug
     * @param  string $slug
     * @return mixed|null
     */
    public static function findSlug(string $slug)
    {
        $query = "SELECT * FROM " . self::$table . " WHERE slug = :slug;";
        $result = Database::getInstance()->query($query, ['slug' => $slug]);

        if(count($result))
        {
            $category = $result[0];
            $category['listings'] = Listing::getForCategory($category['id']);
            return $category;
        }

        return false;
    }

}
