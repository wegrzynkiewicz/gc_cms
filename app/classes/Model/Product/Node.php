<?php

namespace GC\Model\Product;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\NodeTrait;
use GC\Storage\AbstractNode;
use GC\Data;

class Node extends AbstractNode
{
    public static $table      = '::product_nodes';
    public static $frame      = '::product_nodes LEFT JOIN ::frames USING (frame_id)';
    public static $tree       = '::product_nodes LEFT JOIN ::frames USING (frame_id) LEFT JOIN ::product_tree USING (node_id)';
    public static $membership = '::product_nodes LEFT JOIN ::frames USING (frame_id) LEFT JOIN ::product_membership USING (node_id)';

    public static $primary = 'node_id';

    use NodeTrait;

    /**
     * Pobiera wszystkie kategorie dla wszystkich postow włącznie z taksonomią
     */
    public static function selectAllForTaxonomyTree()
    {
        $sql = self::sql("SELECT tax_id, node_id, parent_id, position, post_id, name FROM gc_post_nodes JOIN gc_frames USING (frame_id) JOIN gc_post_membership USING(node_id) JOIN gc_post_tree USING(node_id)");
        $rows = Database::getInstance()->fetchAll($sql);

        return $rows;
    }

    public static function mapNameByPostId($post_id)
    {
        $sql = self::sql("SELECT ::primary, name FROM ::table LEFT JOIN ::post_membership AS p USING (::primary) LEFT JOIN ::frames USING (frame_id) WHERE p.post_id = ?");
        $rows = Database::getInstance()->fetchByMap($sql, [intval($post_id)], static::$primary, 'name');

        return $rows;
    }

    public static function insertWithTaxonomyId(array $data, $tax_id)
    {
        $node_id = parent::insert($data);

        Tree::insert([
            'tax_id' => $tax_id,
            'node_id' => $node_id,
            'parent_id' => null,
            'position' => Tree::selectMaxPositionByTaxonomyIdAndParentId($tax_id, null),
        ]);

        return $node_id;
    }
}
