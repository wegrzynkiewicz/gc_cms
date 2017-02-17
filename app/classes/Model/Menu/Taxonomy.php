<?php

namespace GC\Model\Menu;

use GC\Storage\AbstractModel;

class Taxonomy extends AbstractModel
{
    public static $table   = '::menu_taxonomies';
    public static $primary = 'nav_id';
}
