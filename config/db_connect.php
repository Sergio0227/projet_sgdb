<?php

class Database
{
    public static function connect(): ?\PDO
    {
        $config = require __DIR__ . '/db_config.php';

        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']}";

        try {
            $pdo = new \PDO($dsn, $config['user'], $config['password'], [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);
            return $pdo;
        } catch (\PDOException $e) {
            if ($e) {
                
                error_log("Database connection failed: " . $e->getMessage());
                return null;
            } else {
                return null;
            }
        }
    }
}