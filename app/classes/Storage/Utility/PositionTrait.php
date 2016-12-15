<?php

namespace GC\Storage\Utility;

use GC\Storage\Database;

trait PositionTrait
{
    /**
     * Pobiera najwyzsza pozycje dla $column o wartości $value
     */
    public static function selectMaxPositionBy($column, $value)
    {
        $sql = self::sql("SELECT MAX(position) AS maximum FROM ::table WHERE {$column} = ? LIMIT 1");
        $maxOrder =  Database::fetchSingle($sql, [$value]);

        return $maxOrder['maximum'] + 1;
    }
}
