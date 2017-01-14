<?php

namespace GC\Model\Menu;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\TreeTrait;
use GC\Data;

class Tree extends AbstractModel
{
    public static $table    = '::menu_tree';
    public static $primary  = 'menu_id';
    public static $taxonomy = 'nav_id';

    use TreeTrait;
}
