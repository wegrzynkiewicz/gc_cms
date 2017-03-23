<?php

namespace GC\Model\Navigation;

use GC\Storage\AbstractModel;

class Tree extends AbstractModel
{
    public static $table   = '::navigation_tree';

    public static function insertPositionsToNavigation(array $positions, $navigation_id)
    {
        # usuń wszystkie rekordy budujące drzewo
        static::delete()
            ->equals('navigation_id', $navigation_id)
            ->execute();

        # każdą nadesłaną pozycję wstaw do bazy danych
        foreach ($positions as $node) {

            # pobierz największą pozycję dla węzła w drzewie
            $position = static::select()
                ->fields('MAX(position) AS max')
                ->equals('navigation_id', $navigation_id)
                ->equals('parent_id', $node['parent_id'])
                ->fetch()['max'];

            static::insert([
                'navigation_id' => $navigation_id,
                'node_id' => $node['id'],
                'parent_id' => $node['parent_id'],
                'position' => $position + 1,
            ]);
        }
    }
}
