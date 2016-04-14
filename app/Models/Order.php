<?php

namespace App\Models;

use App\Services\Database;

class Order extends Model
{
    protected static $table = 'orders';

    public static function find($id, $include = false)
    {
        if ($include)
        {
            $query = "SELECT * FROM " . self::$table . " WHERE id = :id";
        }
        else {
            $query = "SELECT * FROM " . self::$table . " WHERE id = :id AND status NOT 'cancelled'";
        }
        $result = Database::getInstance()->query($query, ['id' => $id]);

        if(count($result))
        {
            return $result[0];
        }

        return false;
    }

    public static function getForListing($listingID, $include = false)
    {
        $sql = 'SELECT * FROM orders WHERE listing_id = :listing_id';

        $result = Database::getInstance()->query($sql, ['listing_id' => $listingID]);

        if (count($result) && is_array($result))
        {
            foreach ($result as $order)
            {
                if ($order['status'] != 'cancelled')
                {
                    return $order;
                }
            }
        }
        return false;
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
        $order = self::find($id, true);                
        if (is_array($order)) {

            $listing = Listing::find($order['listing_id']);

            $charged = User::charge($listing['user_id'], $listing['price']);

            // If the listing creator can be charged for the refund, cancel and refund
            if ($charged)
            {
                User::refund($order);
                $sql = "UPDATE orders SET status = 'cancelled' WHERE id = :id";
                Database::getInstance()->query($sql, ['id' => $id]);
                return true;
            }
            return false;
        }
        return false;
    }

    public static function getUserOrders($user)
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

    /**
     * Get the listing for an order
     * @param  int $id the listing id
     * @return array
     */
    public static function findWithListing($id)
    {
        $query = 'SELECT * FROM orders INNER JOIN listings ON orders.listing_id = listings.id WHERE orders.id = :id';
        $result = Database::getInstance()->query($query, ['id' => $id]);
        return $result[0];
    }

    public static function deleteForListing($id)
    {
        $query = 'DELETE FROM orders WHERE listing_id = :id';
        $result = Database::getInstance()->query($query, ['id' => $id]);
    }
}
