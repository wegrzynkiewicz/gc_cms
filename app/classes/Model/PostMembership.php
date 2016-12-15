<?php

namespace GrafCenter\CMS\Model;

use GrafCenter\CMS\Storage\AbstractModel;
use GrafCenter\CMS\Storage\Utility\ColumnTrait;
use GrafCenter\CMS\Storage\Database;

class PostMembership extends AbstractModel
{
    public static $table = '::post_membership';

    use ColumnTrait;
}
