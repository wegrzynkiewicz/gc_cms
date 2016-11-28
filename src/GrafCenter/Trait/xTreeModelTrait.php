<?php

/**
 * Zbiór pomocniczych metod dla wszystkich drzewiastych struktur
 */
trait TreeModelTrait
{

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
     * Usuwa węzeł, a następnie wszystkie węzły, które straciły rodzica
     */
    protected static function xdeleteByPrimaryId($primary_id)
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
}
