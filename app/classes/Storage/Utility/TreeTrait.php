<?php

namespace GC\Storage\Utility;

use GC\Data;

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
        $maxOrder =  Data::get('database')->fetch($sql, $data);

        return $maxOrder['maximum'] + 1;
    }

    protected static function update($tax_id, array $positions)
    {
        static::delete()->equals(static::$taxonomy, $tax_id)->execute();

        foreach ($positions as $node) {
            $parent_id = $node['parent_id'];
            static::insert([
                static::$taxonomy => $tax_id,
                static::$primary => $node['id'],
                'parent_id' => $parent_id,
                'position' => static::selectMaxPositionByTaxonomyIdAndParentId($tax_id, $parent_id),
            ]);
        }
    }
}
