<?php

namespace GC\Model\Menu;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\NodeTrait;
use GC\Storage\AbstractNode;

class Menu extends AbstractNode
{
    public static $table    = '::menus';
    public static $tree     = '::menus LEFT JOIN ::menu_tree USING (menu_id)';
    public static $taxonomy = '::menu_taxonomies LEFT JOIN ::menu_tree USING (nav_id) LEFT JOIN ::menus USING (menu_id) LEFT JOIN ::frames USING (frame_id)';
    public static $primary  = 'menu_id';

    use NodeTrait;
}
