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

    public static function getUserOrders(array $user)
    {
        if (user() == $user) {
            $query = 'SELECT * FROM orders WHERE user_id = :user_id';
            $result = Database::getInstance()->query($query, ['user_id' => $user['id']]);

            if($result)
            {
                foreach($result as $key => $order)
                {
                    $order['listing'] = Listing::find($order['listing_id']);
                    $result[$key] = $order;
                }

                return $result;
            }
            return [];
        }
    }

    public static function create($params)
    {
        foreach($params as $param)
        {
            if($param == '')
            {
                return false;
            }
        }

        $query = 'INSERT INTO ' . self::$table . ' (listing_id, user_id, address, status, created_at)
        VALUES (:listing_id, :user_id, :address, :status, NOW())';

        Database::getInstance()->query($query, $params);

        return true;

    }
}
