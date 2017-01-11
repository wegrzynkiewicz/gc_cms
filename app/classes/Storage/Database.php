<?php

namespace GC\Storage;

use GC\Logger;
use PDO;

/**
 * Słuzy do wykonywania zapytań do bazy danych
 */
class Database
{
    public static $pdo;
    public static $prefix;

    /**
     * Pobiera z configa dane połączeniowe i initializuje połączenie z bazą
     */
    public static function initialize($dbConfig)
    {
        self::$pdo = new PDO($dbConfig['dns'], $dbConfig['username'], $dbConfig['password']);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$prefix = $dbConfig['prefix'];
    }

    /**
     * Wykonuje zapytanie SQL i zwraca jeden wiersz z tego zapytania, przydatne dla pojedyńczych wywołań
     */
    public static function fetch($sql, array $values = [])
    {
        return self::wrapQuery($sql, $values, function ($statement) {
            return $statement->fetch(PDO::FETCH_ASSOC);
        });
    }

    /**
     * Wykonuje zapytanie SQL i zwraca tablice wierszy z tego zapytania, przydatne dla wielu rekordow
     */
    public static function fetchAll($sql, array $values = [])
    {
        return self::wrapQuery($sql, $values, function ($statement) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        });
    }

    /**
     * Wykonuje zapytanie SQL i zwraca tablice wierszy z tego zapytania gdzie
     * kluczem w tej tablicy jest columna przekazana jako $label,
     * przydatne dla wielu rekordow z dostępem swobodnym po kluczu w tablicy
     */
    public static function fetchByKey($sql, array $values, $label)
    {
        $data = [];
        foreach (self::fetchAll($sql, $values) as $row) {
            $data[$row[$label]] = $row;
        }

        return $data;
    }

    /**
     * Wykonuje zapytanie SQL i zwraca tablice wierszy z tego zapytania gdzie
     * kluczem w tej tablicy jest columna przekazana jako $label a wartością jest $column
     * przydatne dla wielu rekordow z dostępem swobodnym po kluczu w tablicy
     */
    public static function fetchByMap($sql, array $values, $label, $column)
    {
        $data = [];
        foreach (self::fetchAll($sql, $values) as $row) {
            $data[$row[$label]] = $row[$column];
        }

        return $data;
    }

    /**
     * Wykonuje zapytanie SQL i zwraca ilość zmodyfikowanych rekordow
     */
    public static function execute($sql, array $values = [])
    {
        return self::wrapQuery($sql, $values, function ($statement) {
            return $statement->rowCount();
        });
    }

    /**
     * Wykonuje zapytanie SQL i zwraca ID ostatniego wstawionego rekordu
     */
    public static function insert($sql, array $values = [])
    {
        self::wrapQuery($sql, $values, function ($statement) {});

        return intval(self::$pdo->lastInsertId());
    }

    /**
     * Przekazaną funkcje $callback otacza wewnątrz transakcji
     */
    public static function transaction($callback)
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

    /**
     * Zamienia kazde napotkanie znaki :: na prefiks bazy danych
     */
    private static function bindTableName($pseudoQuery)
    {
        return preg_replace_callback('/::([a-z_]+)/', function($matches) {
            $property = $matches[1];
            if ($property === 'lang') {
                return sprintf("lang = '%s'", $_SESSION['lang']['editor']);
            }
            return trim(self::$prefix.$property, '_');
        }, $pseudoQuery);
    }

    /**
     * Wywołuje i loguje zapytania
     */
    private static function wrapQuery($sql, array $values, $callback)
    {
        $sql = self::bindTableName($sql);

        Logger::query(trim(sprintf("%s $sql",
            self::$pdo->inTransaction() ? '(TRANSACTION) ::' : ''
        )), $values);

        try {
            $statement = self::$pdo->prepare($sql);
            $statement->execute($values);
            $result = $callback($statement);
        } catch (PDOException $exception) {
            throw new Exception(
                sprintf("Query: %s; Params: %s", $sql, json_encode($values, JSON_PRETTY_PRINT)),
                0,
                $exception
            );
        }
        $statement->closeCursor();

        return $result;
    }
}
