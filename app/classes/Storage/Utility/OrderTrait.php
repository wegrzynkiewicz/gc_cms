<?php

namespace GC\Storage\Utility;

use GC\Storage\Database;

/**
 * Zbior funkcji pomagających operować na rekordach które mają być posortowane w prosty sposób
 * Dla prawidłowego działania wymaga w klasie pochodnej:
 * public static $table = "";
 * public static $primary = "";
 */
trait OrderTrait
{
    /**
     * Pobiera posortowane rekordy po sortowaniu $direct kolumny $column
     */
     public static function selectAllWithPrimaryKeyOrderBy($column, $direct)
     {
         Database::assertColumn($column);
         $sql = self::sql("SELECT * FROM ::table ORDER BY {$column} {$direct}");
         $rows = Database::fetchAllWithKey($sql, [], static::$primary);

         return $rows;
     }
}
