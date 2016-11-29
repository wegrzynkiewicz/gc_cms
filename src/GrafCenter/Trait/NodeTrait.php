<?php

trait NodeTrait
{
    /**
     * Pobiera właściwą taksonomię po zadanym id i buduje z niej drzewo
     */
    public static function buildTreeByTaxonomyId($tax_id)
    {
        $sql = self::sql("SELECT * FROM ::table AS n LEFT JOIN ::treeTable AS t USING (::primary) WHERE t.::taxonomy = ? ORDER BY t.position ASC");
        $nodes =  Database::fetchAllWithKey($sql, [$tax_id], static::$primary);
        $tree = static::createTree($nodes);

        return $tree;
    }

    /**
     * Usuwa węzły, które nie należą do żadnej grupy i nie posiadają rodzica
     */
    protected static function deleteWithoutParentId()
    {
        $sql = self::sql("DELETE n FROM ::table AS n LEFT JOIN ::treeTable AS p USING(::primary) WHERE p.::taxonomy IS NULL");
        $affectedRows = Database::execute($sql);

        return $affectedRows;
    }
}
