<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Database;

class PostMembership extends AbstractModel
{
    public static $table = '::post_membership';

    use ColumnTrait;
}
