<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Database;

class StaffMembership extends AbstractModel
{
    public static $table = '::staff_membership';

    use ColumnTrait;
}
