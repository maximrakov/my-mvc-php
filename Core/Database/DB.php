<?php

namespace App\Core\Database;

use PDO;

class DB
{
    private static $link;

    private static function initConnection(): void
    {
        $dbConfig = require_once (__DIR__ . '/../../config/database.php');
        $dbConfig = $dbConfig['connections'];
        $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']};charset=utf8";
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

    public static function getFields($tableName) {
        $statement = static::execute("SHOW COLUMNS FROM my_db.$tableName");
        $fieldInfo = $statement->fetchAll(PDO::FETCH_ASSOC);
        $fieldNames = [];
        foreach ($fieldInfo as $value) {
            $fieldNames[] = $value['Field'];
        }
        return $fieldNames;
    }

    private static function execute($sql, $params = [])
    {
        if(!static::$link) {
            static::initConnection();
        }
        $statement = static::$link->prepare($sql);
        $statement->execute($params);
        return $statement;
    }

}
