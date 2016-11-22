<?php

class NavNodeModel extends AbstractModel
{
    public static $table   = '::nav_nodes';
    public static $primary = 'node_id';

    public static function selectMaxPositionNode($nav_id, $parent_id)
    {
        $data = [$nav_id];
        if ($parent_id === null) {
            $condition = 'IS NULL';
        } else {
            $condition = ' = ?';
            $data[] = $parent_id;
        }

        $sql = self::sql("SELECT MAX(position) AS maximum FROM ::nav_positions WHERE nav_id = ? AND parent_id {$condition} LIMIT 1");
        $maxOrder =  Database::fetchSingle($sql, $data);

        return $maxOrder['maximum'] + 1;
    }

    public static function deleteByPrimaryId($node_id)
    {
        parent::deleteByPrimaryId($node_id);
        $this->deleteNodesWithoutParentId();
    }

    public static function deleteNodesWithoutParentId()
    {
        $sql = self::sql("DELETE n FROM {self::$table} AS n LEFT JOIN ::nav_positions AS p USING(node_id) WHERE p.nav_id IS NULL");
        Database::execute($sql);
    }

    public static function selectNodesByGroupId($nav_id)
    {
        $sql = self::sql("SELECT * FROM ::table AS n LEFT JOIN ::nav_positions AS p USING (node_id) WHERE p.nav_id = ? ORDER BY position ASC");
        $nodes =  Database::fetchAllWithPrimaryId($sql, [$nav_id], static::$primary);

        return $nodes;
    }

    public static function buildTreeByParentId($nav_id)
    {
        $sql = self::sql("SELECT *, n.node_id AS id FROM ::table AS n LEFT JOIN ::nav_positions AS p USING (node_id) WHERE p.nav_id = ? ORDER BY position ASC");
        $nodes =  Database::fetchAllWithPrimaryId($sql, [$nav_id], static::$primary);

        return createTree($nodes);
    }

    public static function updatePositions($nav_id, array $positions)
    {
        $sql = self::sql("DELETE FROM ::nav_positions WHERE nav_id = ?");
        Database::execute($sql, [$nav_id]);

        foreach ($positions as $node) {
            $parent_id = $node['parent_id'];
            Database::insertDataToTable('::nav_positions', [
                'nav_id' => $nav_id,
                'node_id' => intval($node['id']),
                'parent_id' => $parent_id,
                'position' => $this->selectMaxPositionNode($nav_id, $parent_id),
            ]);
        }
    }

    public static function insertToNav($nav_id, array $data)
    {
        $node_id = parent::insert($data);

        Database::insertDataToTable('::nav_positions', [
            'nav_id' => $nav_id,
            'node_id' => $node_id,
            'position' => $this->selectMaxPositionNode($nav_id, null),
        ]);

        return $node_id;
    }
}
