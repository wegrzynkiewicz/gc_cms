<?php

namespace GC\Model\Product;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\TreeTrait;
use GC\Container;

class Tree extends AbstractModel
{
    public static $table    = '::product_tree';
    public static $primary  = 'node_id';
    public static $taxonomy = 'tax_id';

    use ColumnTrait;
    use TreeTrait;
}
