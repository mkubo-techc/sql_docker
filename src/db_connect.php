<?php

define('DB_USERNAME', 'user');
define('DB_PASSWORD', 'password');
define('DSN', 'mysql:host=mysql; dbname=db; charset=utf8');

function db_connect()
{
    $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
    return $pdo;
}

?>