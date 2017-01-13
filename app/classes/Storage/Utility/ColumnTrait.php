<?php

namespace GC\Storage\Utility;

use GC\Assert;
use GC\Container;

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
        $affectedRows = Container::get('database')->execute($sql, [$value]);

        return $affectedRows;
    }
}
