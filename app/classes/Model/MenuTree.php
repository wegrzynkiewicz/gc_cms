<?php

namespace GrafCenter\CMS\Model;

use GrafCenter\CMS\Storage\AbstractModel;
use GrafCenter\CMS\Storage\Utility\ColumnTrait;
use GrafCenter\CMS\Storage\Utility\TreeTrait;
use GrafCenter\CMS\Storage\Database;

class MenuTree extends AbstractModel
{
    public static $table    = '::menu_tree';
    public static $primary  = 'menu_id';
    public static $taxonomy = 'nav_id';

    use ColumnTrait;
    use TreeTrait;
}
