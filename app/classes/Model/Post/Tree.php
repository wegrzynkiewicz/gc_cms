<?php

namespace GC\Model\Post;

use GC\Storage\AbstractModel;

class Tree extends AbstractModel
{
    public static $table   = '::post_tree';
    public static $primary = 'node_id';
}
