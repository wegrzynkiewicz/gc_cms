<?php

class Database
{
    public static $pdo;
    private static $prefix;

    public static function initialize(PDO $pdo, $prefix)
    {
        self::$pdo = $pdo;
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$prefix = $prefix;
    }

    public static function fetchSingle($sql, array $parameters = [])
    {
        return self::wrapQuery($sql, $parameters, function ($statement) {
            $record = $statement->fetch(PDO::FETCH_ASSOC);

            return $record ? $record : null;
        });
    }

    public static function fetchAll($sql, array $parameters = [])
    {
        return self::wrapQuery($sql, $parameters, function ($statement) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        });
    }

    public static function fetchAllWithPrimaryId($sql, array $parameters, $label)
    {
        return self::wrapQuery($sql, $parameters, function ($statement) use ($label) {
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            $data = array();
            foreach ($rows as $row) {
                $data[$row[$label]] = $row;
            }

            return $data;
        });
    }

    public static function insert($sql, array $parameters = [])
    {
        self::wrapQuery($sql, $parameters, function ($statement) {});

        return intval(self::$pdo->lastInsertId());
    }

    public static function execute($sql, array $parameters = [])
    {
        return self::wrapQuery($sql, $parameters, function ($statement) {
            return $statement->rowCount();
        });
    }

    public static function insertDataToTable($table, array $data)
    {
        $filled = array_fill(0, count($data), '?');
        $values = implode(', ', $filled);

        $columns = array_keys($data);
        foreach ($columns as &$column) {
            $column = "`{$column}`";
        }
        $columns = implode(', ', $columns);
        $insert = "INSERT INTO `{$table}` ({$columns}) VALUES ({$values})";

        return self::insert($insert, array_values($data));
    }

    public static function getUpdateSyntax(array $data)
    {
        $list = [];
        foreach ($data as $field => $value) {
            $list[] = "`{$field}` = ?";
        }

        return implode(', ', $list);
    }

    public static function wrapInTransaction($callback)
    {
        try {
            if (self::$pdo->inTransaction()) {
                $callback();
            }
            self::$pdo->beginTransaction();
            $callback();
            self::$pdo->commit();
        } catch (PDOException $exception) {
            self::$pdo->rollBack();
            throw $exception;
        }
    }

    private static function bindTableName($pseudoQuery)
    {
        return preg_replace_callback('/::(\w+)/', function($matches) {
            $table = $matches[1];
            return trim(self::$prefix.$table, '_');
        }, $pseudoQuery);
    }

    private static function wrapQuery($sql, array $parameters, $callback)
    {
        $sql = self::bindTableName($sql);

        logger(sprintf("[QUERY]%s $sql",
            self::$pdo->inTransaction() ? ' T ::' : ''
        ), $parameters);

        try {
            $statement = self::$pdo->prepare($sql);
            $statement->execute($parameters);
            $result = $callback($statement);
        } catch (PDOException $exception) {
            throw new Exception(
                sprintf("Query: %s; Params: %s", $sql, json_encode($parameters, JSON_PRETTY_PRINT)),
                0,
                $exception
            );
        }
        $statement->closeCursor();

        return $result;
    }
}
