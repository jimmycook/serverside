<?php

namespace App\Services;

use PDO;

class Database
{
    /**
     * @var Singleton The reference to *Singleton* instance of this class
     */
    private static $instance;

    /**
     * @var instance of PDO
     */
    protected $pdo;

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

        if($config['driver'] == 'mysql')
        {
            $host = $config['mysql']['host'];
            $username = $config['mysql']['username'];
            $password = $config['mysql']['password'];
            $database = $config['mysql']['database'];
            $dsn = "mysql:host=$host;dbname=$database;";
            $this->pdo = new PDO($dsn, $username, $password);
            if($this->pdo instanceof PDO)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    public function query($query, $params = [])
    {
        $statement = $this->pdo->prepare($query);
        $result = $statement->execute($params);

        $array = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (count($array))
        {
            return $array;
        }

        return false;
    }

}
