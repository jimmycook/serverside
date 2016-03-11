<?php

namespace App\Services;

class Database
{
    /**
     * @var Singleton The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     */
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Limit access to the constructor for the Singleton pattern
     */
    protected function __construct()
    {
        $this->connection = $this->getConnection();
    }

    private function getConnection()
    {
        $config = require __DIR__ . '/../../config/database.php';

        $driver = $config['driver'];

        if($driver == 'mysql')
        {
            $config
        }
        mew \PDO("")
    }

}
