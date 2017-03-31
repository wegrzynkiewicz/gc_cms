<?php

declare(strict_types=1);

namespace GC\Model\Frame;

use GC\Storage\AbstractModel;

class Relation extends AbstractModel
{
    public static $table = '::frame_relations';

    public static function updateRelations(int $frame_id, array $relations): void
    {
        // usuń wszyskie przynależności
        static::delete()
            ->equals('frame_id', $frame_id)
            ->execute();

        // wstaw przynależności wpisu do węzłów taksonomii
        foreach ($relations as $node_id) {
            static::insert([
                'frame_id' => $frame_id,
                'node_id' => intval($node_id),
            ]);
        }
    }
}
