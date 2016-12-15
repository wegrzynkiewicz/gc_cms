<?php

namespace GCC\Model;

use GCC\Storage\AbstractModel;
use GCC\Storage\Utility\ColumnTrait;
use GCC\Storage\Utility\TreeTrait;
use GCC\Storage\Database;

class PostTree extends AbstractModel
{
    public static $table    = '::post_tree';
    public static $primary  = 'node_id';
    public static $taxonomy = 'tax_id';

    use ColumnTrait;
    use TreeTrait;
}
