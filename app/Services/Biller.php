<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\Listing;
use Carbon\Carbon;

class Biller
{

    /**
     * Key for the biller cookie
     * @var string
     */
    protected $key;

    protected $cookie;

    /**
     * Set up the object
     * @param string $key Cookie key
     */
    public function __construct($key = 'billed')
    {
        $this->key = $key;
        $this->cookie = $this->getCookie();
    }

    /**
     * Bill a listing until midnight the next day
     * @param  array $listing
     * @param  array $user
     * @return boolean
     */
    public function bill(array $listing, array $user)
    {
        // Check there are no active orders for this item, if there are stop billing the user
        if (Order::getForListing($listing['id']))
        {
            $this->timestamp($listing);
            return;
        }

        $paidUntil = Carbon::parse($listing['paid_until'])->setTime(0, 0, 0);

        $days = $paidUntil->diffInDays(Carbon::now()->addDay());

        if ($days > 0)
        {
            $charged = User::charge($user['id'], $days * 100);

            if ($charged)
            {
                $this->timestamp($listing, Carbon::now()->addDay()->setTime(0, 0, 0));
            }
            else
            {
                Listing::deactivate($listing['id']);
            }
        }

    }

    /**
     * Bill all the listings
     * @return void
     */
    public function all()
    {
        // If the cookie is set don't run the biller
        if (!$this->cookie)
        {
            // return;
        }

        // Get all this listings
        $listings = Listing::getAll(false);
;
        foreach ($listings as $listing)
        {
            if ($listing['active'])
            {
                $user = User::find($listing['user_id']);
                $this->bill($listing, $user);
            }
            else
            {
                $this->timestamp($listing);
            }
        }

        $this->setCookie();
    }

    /**
     * Set the cookie
     * @return void
     */
    public function setCookie()
    {
        $time = Carbon::now()->addHour();
        Cookie::set($this->key, true , $time);
        $this->cookie = true;
    }

    /**
     * Get the cookie
     * @return mixed
     */
    public function getCookie()
    {
        return Cookie::get($this->key);
    }

    /**
     * Set the timestamp on a listing
     * @param  [type] $listing
     * @param  Carbon\Carbon $timestamp
     * @return void
     */
    public function timestamp($listing, Carbon $timestamp = null)
    {
        if ($timestamp == null)
        {
            $timestamp = Carbon::now();
        }

        if (Carbon::parse($listing['paid_until'])->lt($timestamp))
        {
            Listing::setPaidUntil($listing['id'], $timestamp);
        }
    }

}
