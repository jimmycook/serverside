<?php

namespace App\Models;

use App\Services\Database;

class Order
{

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
        $sql = "UPDATE orders SET status = 'completed' WHERE id = :id";
        return $result = Database::getInstance()->query($sql, ['id' => $id]);
    }
}
