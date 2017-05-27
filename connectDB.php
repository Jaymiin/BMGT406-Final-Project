<?php

// local host configuration
// values for $dsn, $username, $password are in sqlcommands.sql

// bmgt406 server configuration
// values for $dsn, $username, $password are in sqlcommands.sql

    $dsn = 'mysql:host=bmgt406.rhsmith.umd.edu;dbname=bmgt406_02_db';
    $username = 'bmgt406_02';
    $password = 'bmgt406_02';

// Use try/catch/PDO/PDOException to open a connection to the database.
 try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('connect_database_error.php');
        exit();
    }

// $db will point to a new instance of the PDO class..
// Remember to include the script connect_database_error.php

?>