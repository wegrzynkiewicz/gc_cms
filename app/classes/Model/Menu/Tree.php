<?php

namespace GC\Model\Menu;

use GC\Storage\AbstractModel;

class Tree extends AbstractModel
{
    public static $table   = '::menu_tree';
    public static $primary = 'menu_id';
}
