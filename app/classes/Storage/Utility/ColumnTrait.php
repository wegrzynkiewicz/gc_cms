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
