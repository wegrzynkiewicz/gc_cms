<?php

namespace GrafCenter\CMS\Storage\Utility;

use GrafCenter\CMS\Storage\Database;

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
     * Usuwa wiele rekordow z bazy danych po kolumnie $column i wartości $value
     */
    protected static function deleteAllBy($column, $value)
    {
        $sql = self::sql("DELETE FROM ::table WHERE {$column} = ?");
        $affectedRows = Database::execute($sql, [$value]);

        return $affectedRows;
    }
}
