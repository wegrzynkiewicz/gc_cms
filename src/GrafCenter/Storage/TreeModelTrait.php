<?php

/**
 * Zbiór pomocniczych metod dla wszystkich drzewiastych struktur
 */
trait TreeModelTrait
{
    /**
     * Pobiera wszystkie węzły dla zadanej grupy
     */
    public static function selectNodesByGroupId($group_id)
    {
        $sql = self::sql("SELECT * FROM ::table AS n LEFT JOIN ::groupTable AS p USING (::primary) WHERE p.::groupName = ? ORDER BY position ASC");
        $nodes =  Database::fetchAllWithPrimaryId($sql, [$group_id], static::$primary);

        return $nodes;
    }

    /**
     * Pobiera najwyższą pozycję dla nowego węzła dla zadanej grupy i rodzica
     */
    public static function selectMaxPositionNode($group_id, $parent_id)
    {
        $data = [$group_id];
        if ($parent_id === null) {
            $condition = 'IS NULL';
        } else {
            $condition = ' = ?';
            $data[] = $parent_id;
        }

        $sql = self::sql("SELECT MAX(position) AS maximum FROM ::groupTable AS p WHERE p.::groupName = ? AND parent_id {$condition} LIMIT 1");
        $maxOrder =  Database::fetchSingle($sql, $data);

        return $maxOrder['maximum'] + 1;
    }

    /**
     * Usuwa węzły (nie rekordy w tabelce łącznikowej!), które nie należą do żadnej grupy i nie posiadają rodzica
     */
    protected static function deleteNodesWithoutParentId()
    {
        $sql = self::sql("DELETE n FROM ::table AS n LEFT JOIN ::groupTable AS p USING(::primary) WHERE p.::groupName IS NULL");
        Database::execute($sql);
    }

    /**
     * Usuwa węzeł, a następnie wszystkie węzły, które straciły rodzica
     */
    protected static function deleteByPrimaryId($primary_id)
    {
        parent::deleteByPrimaryId($primary_id);
        static::deleteNodesWithoutParentId();
    }

    /**
     * Usuwa wszystkie połączenia z tabelki łącznikowej dla zadanej grupy
     */
    protected static function deleteAllJoinsByGroupId($group_id)
    {
        $sql = self::sql("DELETE FROM ::groupTable WHERE ::groupName = ?");
        Database::execute($sql, [$group_id]);
    }

    protected static function updatePositions($group_id, array $positions)
    {
        static::deleteAllJoinsByGroupId($group_id);

        foreach ($positions as $node) {
            $parent_id = $node['parent_id'];
            Database::buildInsert(static::$groupTable, [
                static::$groupName => $group_id,
                static::$primary => $node['id'],
                'parent_id' => $parent_id,
                'position' => static::selectMaxPositionNode($group_id, $parent_id),
            ]);
        }
    }

    protected static function insertToGroupId($group_id, array $data)
    {
        $primary_id = parent::insert($data);

        Database::buildInsert(static::$groupTable, [
            static::$groupName => $group_id,
            static::$primary => $primary_id,
            'position' => static::selectMaxPositionNode($group_id, null),
        ]);

        return $primary_id;
    }
}
