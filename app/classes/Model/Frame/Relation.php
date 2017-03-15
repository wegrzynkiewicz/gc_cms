<?php

namespace GC\Model\Frame;

use GC\Storage\AbstractModel;

class Relation extends AbstractModel
{
    public static $table   = '::frame_relations';

    public static function updateRelations($frame_id, array $relations)
    {
        # usuń wszyskie przynależności
        static::delete()
            ->equals('frame_id', intval($frame_id))
            ->execute();

        # wstaw przynależności wpisu do węzłów taksonomii
        foreach ($relations as $node_id) {
            static::insert([
                'frame_id' => intval($frame_id),
                'node_id' => intval($node_id),
            ]);
        }
    }
}
