<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\ContainFrameTrait;
use GC\Storage\Database;

class Post extends AbstractModel
{
    public static $table   = '::posts';
    public static $primary = 'post_id';

    use PrimaryTrait;
    use ContainFrameTrait;

    protected static function update($post_id, array $data, array $relations)
    {
        # zaktualizuj pracownika
        parent::updateByPrimaryId($post_id, $data);
        static::updateRelations($post_id, $relations);
    }

    protected static function insert(array $data, array $relations)
    {
        # wstaw pracownika
        $post_id = parent::insert($data);
        static::updateRelations($post_id, $relations);
    }

    /**
     * Aktualizuje przynaleznosc do taksonomii postu
     */
    private static function updateRelations($post_id, array $relations)
    {
        # usuń wszystkie grupy tego pracownika
        PostMembership::deleteAllBy('post_id', $post_id);

        # wstaw na nowo grupy pracownika
        foreach ($relations as $node_id) {
            PostMembership::insert([
                'post_id' => $post_id,
                'node_id' => $node_id,
            ]);
        }
    }
}
