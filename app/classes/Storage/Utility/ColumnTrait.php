<?php

namespace GC\Storage\Utility;

use GC\Assert;
use GC\Storage\Database;

/**
 * Zbior funkcji pomagających operować na jakimkolwiek polu
 * Dla prawidłowego działania wymaga w klasie pochodnej:
 * public static $table = "";
 */
trait ColumnTrait
{
    /**
     * Pobiera jeden rekord z bazy danych po kolumnie $column i wartości $value
     */
    public static function selectSingleBy($column, $value)
    {
        Assert::column($column);
        $sql = self::sql("SELECT * FROM ::table WHERE {$column} = ? LIMIT 1");
        $row = Database::fetch($sql, [$value]);

        return $row;
    }

    /**
     * Pobiera wszystkie rekordy z bazy danych po kolumnie $column i wartości $value, gdzie kluczem jest $key
     */
    public static function selectAllWithKeyBy($column, $value, $key)
    {
        Assert::column($column);
        Assert::column($key);
        $sql = self::sql("SELECT * FROM ::table WHERE {$column} = ?");
        $row = Database::fetchByKey($sql, [$value], $key);

        return $row;
    }

    /**
     * Pobiera ilość rekordów w tabeli dla $column równemu $value
     */
    public static function countBy($column, $value)
    {
        Assert::column($column);
        $sql = self::sql("SELECT COUNT(*) AS count FROM ::table WHERE {$column} = ? LIMIT 1");
        $data = Database::fetch($sql, [$value]);

        return intval($data['count']);
    }

    /**
     * Usuwa wiele rekordow z bazy danych po kolumnie $column i wartości $value
     */
    protected static function deleteAllBy($column, $value)
    {
        Assert::column($column);
        $sql = self::sql("DELETE FROM ::table WHERE {$column} = ?");
        $affectedRows = Database::execute($sql, [$value]);

        return $affectedRows;
    }
}
