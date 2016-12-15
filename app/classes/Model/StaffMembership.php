<?php

namespace GCC\Model;

use GCC\Storage\AbstractModel;
use GCC\Storage\Utility\ColumnTrait;
use GCC\Storage\Database;

class StaffMembership extends AbstractModel
{
    public static $table = '::staff_membership';

    use ColumnTrait;
}
