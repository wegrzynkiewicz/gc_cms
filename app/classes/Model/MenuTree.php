<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\TreeTrait;
use GC\Storage\Database;

class MenuTree extends AbstractModel
{
    public static $table    = '::menu_tree';
    public static $primary  = 'menu_id';
    public static $taxonomy = 'nav_id';

    use ColumnTrait;
    use TreeTrait;
}
