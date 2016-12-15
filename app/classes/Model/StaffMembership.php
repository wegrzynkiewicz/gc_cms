<?php

namespace GrafCenter\CMS\Model;

use GrafCenter\CMS\Storage\AbstractModel;
use GrafCenter\CMS\Storage\Utility\ColumnTrait;
use GrafCenter\CMS\Storage\Database;

class StaffMembership extends AbstractModel
{
    public static $table = '::staff_membership';

    use ColumnTrait;
}
