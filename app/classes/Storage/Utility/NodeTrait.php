<?php

namespace GC\Storage\Utility;

use GC\Data;

/**
 * Zbior funkcji pomagających operować na węźle
 * Dla prawidłowego działania wymaga w klasie pochodnej:
 * public static $table = "";
 * public static $primary = "";
 * public static $treeTable = "";
 * public static $taxonomy = "";
 */
trait NodeTrait
{
    /**
     * Usuwa węzeł i wszystkie podwęzły które nie należą do żadnej grupy i nie posiadają rodzica
     */
    public static function deleteNodeByPrimaryId($primary_id)
    {
        static::deleteByPrimaryId($primary_id);
        static::deleteWithoutParentId();
    }

    /**
     * Usuwa węzły, które nie należą do żadnej grupy i nie posiadają rodzica
     */
    public static function deleteWithoutParentId()
    {
        $sql = self::sql("DELETE n FROM ::table AS n LEFT JOIN ::treeTable AS p USING(::primary) WHERE p.::taxonomy IS NULL");
        $affectedRows = Database::getInstance()->execute($sql);

        return $affectedRows;
    }
}
