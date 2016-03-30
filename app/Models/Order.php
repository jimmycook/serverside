<?php

namespace App\Models;

use App\Services\Database;

class Order extends Model
{
    protected static $table = 'orders';

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

    public static function getForListing($listingID)
    {
        $sql = 'SELECT * FROM orders WHERE listing_id = :listing_id';
        $result = Database::getInstance()->query($sql, ['listing_id' => $listingID]);
        if($result){
            return $result[0];
        }
        else {
            return false;
        }
    }

    public static function complete($id)
    {
        $sql = "SELECT * FROM orders WHERE id = :id";
        $result = Database::getInstance()->query($sql, ['id' => $id]);

        if (is_array($result)) {
            $sql = "UPDATE orders SET status = 'completed' WHERE id = :id";
            Database::getInstance()->query($sql, ['id' => $id]);
            return true;
        }
        return false;
    }

    public static function cancel($id)
    {
        $sql = "SELECT * FROM orders WHERE id = :id";
        $result = Database::getInstance()->query($sql, ['id' => $id]);

        if (is_array($result)) {
            $sql = "UPDATE orders SET status = 'cancelled' WHERE id = :id";
            Database::getInstance()->query($sql, ['id' => $id]);
            User::refund($result[0]);
            return true;
        }
        return false;
    }
}
