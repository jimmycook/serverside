<?php

namespace App\Services;

use App\Models\User;
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
        $paidUntil = Carbon::parse($listing['paid_until'])->setTime(0, 0, 0);

        $days = $paidUntil->diffInDays(Carbon::now()->addDay());

        if ($days > 0)
        {
            $charged = User::charge($user['id'], $days * 100);

            if ($charged)
            {
                Listing::setPaidUntil($listing['id'], Carbon::now()->addDay()->setTime(0, 0, 0));
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

        foreach ($listings as $listing)
        {
            if ($listing['active'])
            {
                $user = User::find($listing['user_id']);
                $this->bill($listing, $user);
            }
            else
            {
                // Set paid until to now if it hasn't already been billed past now
                if (Carbon::parse($listing['paid_until'])->lt(Carbon::now()))
                {
                    Listing::setPaidUntil($listing['id'], Carbon::now());
                }
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
     * Flush out the cookie
     * @return void
     */
    public function flushCookie()
    {

    }

}
