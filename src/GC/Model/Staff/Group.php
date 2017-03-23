<?php

namespace GC\Model\Staff;

use GC\Storage\AbstractModel;

class Group extends AbstractModel
{
    public static $table    = '::staff_groups';
    public static $primary  = 'group_id';
    public static $groups   = '::staff_membership LEFT JOIN ::staff_groups USING(group_id)';
}
