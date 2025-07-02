<?php

namespace App\Helper;

class DbConnect
{
    private static $connection;

    public static function getConnection(): \PDO
    {
        if (!self::$connection) {
            $host = 'localhost';
            $dbname = 'test';
            $username = 'root';
            $password = '';

            self::$connection = new \PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $username,
                $password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                ]
            );
        }
        return self::$connection;
    }
}
