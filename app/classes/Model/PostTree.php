<?php

namespace GrafCenter\CMS\Model;

use GrafCenter\CMS\Storage\AbstractModel;
use GrafCenter\CMS\Storage\Utility\ColumnTrait;
use GrafCenter\CMS\Storage\Utility\TreeTrait;
use GrafCenter\CMS\Storage\Database;

class PostTree extends AbstractModel
{
    public static $table    = '::post_tree';
    public static $primary  = 'node_id';
    public static $taxonomy = 'tax_id';

    use ColumnTrait;
    use TreeTrait;
}
