<?php

class PostCategory extends Node
{
    public static $table   = '::post_categories';
    public static $treeTable = '::post_tree';
    public static $primary = 'cat_id';
    public static $taxonomy = 'tax_id';

    public static $cache = [];
    public static $primaryIdLabel = "cat_id";
    public static $parentIdLabel  = "parent_id";

    use NodeTrait;
    use PrimaryTrait;
    use TaxonomyTrait;

    /**
     * Pobiera wszystkie kategorie dla wszystkich postow włącznie z taksonomią
     */
    public static function selectAllWithTaxonomyId()
    {
        $sql = self::sql("SELECT * FROM ::post_membership JOIN ::table USING(::primary) JOIN ::treeTable USING(::primary)");
        $rows = Database::fetchAll($sql);

        return $rows;
    }

    public static function selectAllAsOptionsPostId($post_id)
    {
        $sql = self::sql("SELECT * FROM ::table LEFT JOIN ::post_membership AS p USING (::primary) WHERE p.post_id = ?");
        $rows = Database::fetchAsOptionsWithPrimaryId($sql, [intval($post_id)], static::$primary, static::$primary);

        return $rows;
    }

    protected static function insert(array $data, $tax_id)
    {
        $cat_id = parent::insert($data);

        PostTree::insert([
            'tax_id' => $tax_id,
            'cat_id' => $cat_id,
            'parent_id' => null,
            'position' => PostTree::selectMaxPositionByTaxonomyIdAndParentId($tax_id, null),
        ]);

        return $cat_id;
    }
}
