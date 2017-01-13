<?php

namespace GC\Storage\Utility;

use GC\Assert;
use GC\Container;

trait PositionTrait
{
    /**
     * Pobiera najwyzsza pozycje dla $column o wartości $value
     */
    public static function selectMaxPositionBy($column, $value)
    {
        Assert::column($column);
        $sql = self::sql("SELECT MAX(position) AS maximum FROM ::table WHERE {$column} = ? LIMIT 1");
        $maxOrder =  Container::get('database')->fetch($sql, [$value]);

        return $maxOrder['maximum'] + 1;
    }
}
