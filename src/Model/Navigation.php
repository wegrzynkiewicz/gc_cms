<?php

namespace GC\Model;

use GC\Model\Navigation\Node;
use GC\Storage\AbstractModel;

class Navigation extends AbstractModel
{
    public static $table   = '::navigations';
    public static $primary = 'navigation_id';

    /**
     * Usuwa nawigację i wszystkie węzeł
     */
    public static function deleteByNavigationId($navigation_id)
    {
        # pobierz węzły nawigacji
        $nodes = Node::select()
            ->fields(['node_id'])
            ->source('::tree')
            ->equals('navigation_id', $navigation_id)
            ->fetchByPrimaryKey();

        # usuń każdy węzeł nawigacji
        foreach ($nodes as $node_id => $node) {
            Node::deleteByNodeId($node_id);
        }

        # usuń nawigację
        static::deleteByPrimaryId($navigation_id);
    }
}
