<?php

namespace Core\database;

use Exception;
use PDO;

class Connection
{
    public static function make()
    {
        $connection = env('DB_CONNECTION');
        $dbName = env('DB_NAME');
        $host = env('DB_HOST');
        try {
            return new PDO(
                "{$connection}:dbname={$dbName};host={$host}",
                env('DB_USERNAME'),
                env('DB_PASSWORD')
            );
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
