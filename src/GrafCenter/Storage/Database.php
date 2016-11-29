<?php

/**
 * Słuzy do wykonywania zapytań do bazy danych
 */
class Database
{
    public static $pdo;
    public static $langEditor;
    public static $prefix;

    /**
     * Wykonuje zapytanie SQL i zwraca jeden wiersz z tego zapytania, przydatne dla pojedyńczych wywołań
     */
    public static function fetchSingle($sql, array $parameters = [])
    {
        return self::wrapQuery($sql, $parameters, function ($statement) {
            return $statement->fetch(PDO::FETCH_ASSOC);
        });
    }

    /**
     * Wykonuje zapytanie SQL i zwraca tablice wierszy z tego zapytania, przydatne dla wielu rekordow
     */
    public static function fetchAll($sql, array $parameters = [])
    {
        return self::wrapQuery($sql, $parameters, function ($statement) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        });
    }

    /**
     * Wykonuje zapytanie SQL i zwraca tablice wierszy z tego zapytania gdzie
     * kluczem w tej tablicy jest columna przekazana jako $label,
     * przydatne dla wielu rekordow z dostępem swobodnym po kluczu w tablicy
     */
    public static function fetchAllWithKey($sql, array $parameters, $label)
    {
        $data = [];
        foreach (self::fetchAll($sql, $parameters) as $row) {
            $data[$row[$label]] = $row;
        }

        return $data;
    }

    /**
     * Wykonuje zapytanie SQL i zwraca tablice wierszy z tego zapytania gdzie
     * kluczem w tej tablicy jest columna przekazana jako $label a wartością jest $column
     * przydatne dla wielu rekordow z dostępem swobodnym po kluczu w tablicy
     */
    public static function fetchAsOptionsWithPrimaryId($sql, array $parameters, $label, $column)
    {
        $data = [];
        foreach (self::fetchAll($sql, $parameters) as $row) {
            $data[$row[$label]] = $row[$column];
        }

        return $data;
    }

    /**
     * Wykonuje zapytanie SQL i zwraca ilość zmodyfikowanych rekordow
     */
    public static function execute($sql, array $parameters = [])
    {
        return self::wrapQuery($sql, $parameters, function ($statement) {
            return $statement->rowCount();
        });
    }

    /**
     * Wykonuje zapytanie SQL i zwraca ID ostatniego wstawionego rekordu
     */
    public static function insert($sql, array $parameters = [])
    {
        self::wrapQuery($sql, $parameters, function ($statement) {});

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
        return preg_replace_callback('/::(\w+)/', function($matches) {
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
