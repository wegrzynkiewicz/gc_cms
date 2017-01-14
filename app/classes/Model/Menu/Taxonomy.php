<?php

namespace GC\Model\Menu;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Data;

class Taxonomy extends AbstractModel
{
    public static $table     = '::menu_taxonomies';
    public static $primary   = 'nav_id';

    use PrimaryTrait;
}
