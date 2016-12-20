<?php

namespace GC\Storage\Utility;

use GC\Storage\Database;
use GC\Storage\Criteria;

/**
 * Zbior funkcji pomagających operować na obiekcie Criteria
 * Dla prawidłowego działania wymaga w klasie pochodnej:
 * public static $table = "";
 */
trait CriteriaTrait
{
    /**
     * Pobiera wybrane kolumny wszystkich rekordów dla zadanego kryterium
     */
    public static function selectAllByCriteria(array $columns, Criteria $criteria)
    {
        array_map(function ($column) {
            Database::assertColumn($column);
        }, $fields);

        $select = implode(', ', $columns);
        $sql = self::sql("SELECT {$select} FROM ::table {$criteria}");
        $rows = Database::fetchAll($sql, $criteria->getValues());

        return $rows;
    }

    /**
     * Pobiera ilość rekordów przefiltrowanych przez zadane kryterium
     */
    public static function countByCriteria(Criteria $criteria)
    {
        $copy = clone $criteria;
        $copy->clearLimit();
        $copy->clearSort();
        $sql = self::sql("SELECT COUNT(*) AS count FROM ::table {$copy}");
        $data = Database::fetchSingle($sql, $copy->getValues());

        return intval($data['count']);
    }
}
