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
