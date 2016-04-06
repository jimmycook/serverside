Server-side
-------------

This is my coursework for server-side web development at Abertay University.

The course teaches PHP in a procedural way, however I've decided to employee the Model View Controller pattern to keep the project structured and extendable in a clean way. To achieve this I'm using a small library called PHRoute to handle routing the requests by their URI to the appropriate logic code.

The entry point for the application is the index.php file in the public folder, and the public folder should be set up as the document root of the web server. The database connection information is stored within database/config.php

Set-up
-----

To set up, create a database table and store the details in /config/database.php in the following form. Currently this application only supports mysql.
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
