<?php

namespace GC\Model\Staff;

use GC\Storage\AbstractModel;

class Staff extends AbstractModel
{
    public static $table   = '::staff';
    public static $primary = 'staff_id';
    public static $session = '::staff JOIN ::staff_sessions USING(staff_id)';
}
