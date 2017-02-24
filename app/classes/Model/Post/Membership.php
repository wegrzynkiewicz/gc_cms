<?php

namespace GC\Model\Post;

use GC\Storage\AbstractModel;

class Membership extends AbstractModel
{
    public static $table = '::post_membership';

    public static function updateMembership($frame_id, array $memberships)
    {
        # usuń wszyskie przynależności wpisu
        static::delete()
            ->equals('frame_id', intval($frame_id))
            ->execute();

        # wstaw przynależności wpisu do węzłów taksonomii
        foreach ($memberships as $node_id) {
            static::insert([
                'frame_id' => intval($frame_id),
                'node_id' => intval($node_id),
            ]);
        }
    }
}
