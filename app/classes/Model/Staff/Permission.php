<?php

namespace GC\Model\Staff;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Container;

class Permission extends AbstractModel
{
    public static $table = '::staff_permissions';

    use ColumnTrait;
}
