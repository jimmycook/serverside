Server-side
-------------

This is my coursework for server-side web development at Abertay University.

Set-up
-----
Requirements:
* PHP 7
* composer
* (optional) node/npm if you would like to recompile the styles

In the command line
 ```bash
composer install
npm install
 ```



To set up, create a database table and store the details in /config/database.php in the following form. Currently this application only supports mysql.

Import the database into mysql from the db.sql file included.

```php
<?php
// Setup your database connection here
return [
    'driver' => 'mysql',

    'mysql' => [
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'database' => 'serverside',
    ],
];
```
