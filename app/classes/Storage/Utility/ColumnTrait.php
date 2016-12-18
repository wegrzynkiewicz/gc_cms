<?php

namespace GC\Storage\Utility;

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
        $sql = self::sql("SELECT * FROM ::table WHERE {$column} = ? LIMIT 1");
        $row = Database::fetchSingle($sql, [$value]);

        return $row;
    }

    /**
     * Pobiera wszystkie rekordy z bazy danych po kolumnie $column i wartości $value, gdzie kluczem jest $key
     */
    public static function selectAllWithKeyBy($column, $value, $key)
    {
        $sql = self::sql("SELECT * FROM ::table WHERE {$column} = ?");
        $row = Database::fetchAllWithKey($sql, [$value], $key);

        return $row;
    }

    /**
     * Usuwa wiele rekordow z bazy danych po kolumnie $column i wartości $value
     */
    protected static function deleteAllBy($column, $value)
    {
        $sql = self::sql("DELETE FROM ::table WHERE {$column} = ?");
        $affectedRows = Database::execute($sql, [$value]);

        return $affectedRows;
    }
}
