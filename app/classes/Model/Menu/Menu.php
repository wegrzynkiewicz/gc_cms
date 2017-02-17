<?php

namespace GC\Model\Menu;

use GC\Storage\AbstractNode;

class Menu extends AbstractNode
{
    public static $table        = '::menus';
    public static $primary      = 'menu_id';
    public static $node         = 'menu_id';
    public static $taxonomy     = '::menu_taxonomies LEFT JOIN ::menu_tree USING (nav_id) LEFT JOIN ::menus USING (menu_id) LEFT JOIN ::frames USING (frame_id)';
    public static $tree         = '::menus LEFT JOIN ::menu_tree USING (menu_id)';
    public static $aloneNodes   = '::menu_tree RIGHT JOIN ::menus USING(menu_id)';

    /**
     * Usuwa węzeł i wszystkie węzły potomne
     */
    public static function deleteByMenuId($menu_id)
    {
        # usuń węzeł nawigacji
        static::deleteByPrimaryId($menu_id);

        # pobierz węzły nawigacji, które nie są przypisane do drzewa
        $nodes = static::select()
            ->fields(['menu_id'])
            ->source('::aloneNodes')
            ->equals('nav_id', null)
            ->fetchAll();

        # usuń każdy samotny węzeł nawigacji
        foreach ($nodes as $node) {
            static::deleteByPrimaryId($node['menu_id']);
        }
    }
}
