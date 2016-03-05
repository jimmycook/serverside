<?php

namespace App\Database;

// Class to connect to the database and run queries using PDO
class DatabaseConnection
{

    protected $username;

    protected $username;

    protected $username;

    public function __construct()
    {
        $this->username = getenv('MYSQL_USER');
        $this->password = getenv('MYSQL_PASSWORD');
        $this->database = getenv('MYSQL_DATABASE');

    }
}
