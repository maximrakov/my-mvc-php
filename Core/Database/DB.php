<?php

namespace App\Core\Database;

use App\Core\Config;
use PDO;

class DB
{
    private static $link;

    private static function initConnection(): void
    {
        $dbConfig = Config::get('database.connections');
        $dsn = "{$dbConfig['driver']}:host={$dbConfig['host']};dbname={$dbConfig['database']};charset=utf8";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        static::$link = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $opt);
    }

    public static function select($sql, $params = [])
    {
        $statement = static::execute($sql, $params);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function insert($sql, $params = []): void
    {
        $statement = static::execute($sql, $params);
    }

    public static function update($sql, $params = [])
    {
        $statement = static::execute($sql, $params);
        return $statement->rowCount();
    }

    public static function delete($sql, $params = [])
    {
        $statement = static::execute($sql, $params);
        return $statement->rowCount();
    }

    public static function statement($sql, $params = [])
    {
        $statement = static::execute($sql, $params);
    }

    private static function execute($sql, $params = [])
    {
        if (!static::$link) {
            static::initConnection();
        }
        $statement = static::$link->prepare($sql);
        $statement->execute($params);
        return $statement;
    }

}
