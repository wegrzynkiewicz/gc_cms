<?php

namespace GC\Model\Post;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Container;

class Membership extends AbstractModel
{
    public static $table = '::post_membership';

    use ColumnTrait;
}
