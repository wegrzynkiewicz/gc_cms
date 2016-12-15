<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\TreeTrait;
use GC\Storage\Database;

class PostTree extends AbstractModel
{
    public static $table    = '::post_tree';
    public static $primary  = 'node_id';
    public static $taxonomy = 'tax_id';

    use ColumnTrait;
    use TreeTrait;
}
