<?php

class MenuPosition extends Model
{
    public static $table  = '::nav_positions';

    use ColumnTrait;

    /**
     * Pobiera najwyższą pozycję dla nowego węzła dla zadanej grupy i rodzica
     */
    public static function selectMaxPositionByNavIdAndParentId($nav_id, $parent_id)
    {
        $data = [$nav_id];
        if ($parent_id === null) {
            $condition = 'IS NULL';
        } else {
            $condition = ' = ?';
            $data[] = $parent_id;
        }

        $sql = self::sql("SELECT MAX(position) AS maximum FROM ::table AS p WHERE p.nav_id = ? AND parent_id {$condition} LIMIT 1");
        $maxOrder =  Database::fetchSingle($sql, $data);

        return $maxOrder['maximum'] + 1;
    }

    protected static function update($nav_id, array $positions)
    {
        static::deleteAllBy('nav_id', $nav_id);

        foreach ($positions as $node) {
            $parent_id = $node['parent_id'];
            static::insert([
                'nav_id' => $nav_id,
                'menu_id' => $node['id'],
                'parent_id' => $parent_id,
                'position' => static::selectMaxPositionByNavIdAndParentId($nav_id, $parent_id),
            ]);
        }
    }
}
