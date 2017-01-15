<?php

namespace GC\Model\Post;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\ContainFrameTrait;
use GC\Data;

class Post extends AbstractModel
{
    public static $table   = '::posts';
    public static $primary = 'post_id';

    use PrimaryTrait;
    use ContainFrameTrait;

    public static function update($post_id, array $data, array $relations)
    {
        # zaktualizuj pracownika
        parent::updateByPrimaryId($post_id, $data);
        static::updateRelations($post_id, $relations);
    }

    public static function insertWithRelations(array $data, array $relations)
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
        Membership::delete()->equals('post_id', $post_id)->execute();

        # wstaw na nowo grupy pracownika
        foreach ($relations as $node_id) {
            Membership::insert([
                'post_id' => $post_id,
                'node_id' => $node_id,
            ]);
        }
    }
}