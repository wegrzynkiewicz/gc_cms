<?php

namespace GC\Storage\Utility;

use GC\Storage\Database;

trait TreeTrait
{
    /**
     * Pobiera najwyższą pozycję dla nowego węzła dla zadanej taksonomii i rodzica
     */
    public static function selectMaxPositionByTaxonomyIdAndParentId($tax_id, $parent_id)
    {
        $data = [$tax_id];
        if ($parent_id === null) {
            $condition = 'IS NULL';
        } else {
            $condition = ' = ?';
            $data[] = $parent_id;
        }

        $sql = self::sql("SELECT MAX(position) AS maximum FROM ::table AS p WHERE p.::taxonomy = ? AND parent_id {$condition} LIMIT 1");
        $maxOrder =  Database::getInstance()->fetch($sql, $data);

        return $maxOrder['maximum'] + 1;
    }
}
