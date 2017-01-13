<?php

namespace GC\Model\Staff;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Container;

class Membership extends AbstractModel
{
    public static $table = '::staff_membership';

    use ColumnTrait;
}
