<?php

namespace GCC\Model;

use GCC\Storage\AbstractModel;
use GCC\Storage\Utility\ColumnTrait;
use GCC\Storage\Database;

class PostMembership extends AbstractModel
{
    public static $table = '::post_membership';

    use ColumnTrait;
}
