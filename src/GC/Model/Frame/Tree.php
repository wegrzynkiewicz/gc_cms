<?php

declare(strict_types=1);

namespace GC\Model\Frame;

use GC\Model\Frame;
use GC\Storage\AbstractNode;

class Tree extends AbstractNode
{
    public static $table = '::frame_tree';

    /**
     *
     */
    public static function insertPositionsToTaxonomy(array $positions, $taxonomy_id)
    {
        # usuń wszystkie rekordy budujące drzewo
        static::delete()
            ->equals('taxonomy_id', $taxonomy_id)
            ->execute();

        # każdą nadesłaną pozycję wstaw do bazy danych
        foreach ($positions as $node) {

            # pobierz największą pozycję dla węzła w drzewie
            $position = static::select()
                ->fields('MAX(position) AS max')
                ->equals('taxonomy_id', $taxonomy_id)
                ->equals('parent_id', $node['parent_id'])
                ->fetch()['max'];

            static::insert([
                'frame_id' => $node['id'],
                'parent_id' => $node['parent_id'],
                'taxonomy_id' => $taxonomy_id,
                'position' => $position + 1,
            ]);
        }
    }

    /**
     *
     */
    public static function insertFrameToTaxonomy($frame_id, $taxonomy_id)
    {
        # pobierz największą pozycję dla węzła w drzewie
        $position = static::select()
            ->fields('MAX(position) AS max')
            ->equals('taxonomy_id', $taxonomy_id)
            ->equals('parent_id', null)
            ->fetch()['max'];

        # dodaj węzeł do pozycji w drzewie taksonomi
        static::insert([
            'taxonomy_id' => $taxonomy_id,
            'frame_id' => $frame_id,
            'parent_id' => null,
            'position' => $position+1,
        ]);
    }
}
