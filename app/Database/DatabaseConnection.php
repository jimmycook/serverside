<?php

namespace App\Database;

// Class to connect to the database and run queries using PDO
class DatabaseConnection
{

    public function __construct()
    {
        $config = require __DIR__ . '/../../database/config.php';
        
    }
}
