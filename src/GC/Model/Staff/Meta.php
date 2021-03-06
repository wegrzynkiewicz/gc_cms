<?php

declare(strict_types=1);

namespace GC\Model\Staff;

use GC\Storage\AbstractModel;

class Meta extends AbstractModel
{
    public static $table = '::staff_meta';
    public static $meta = 'staff_id';
}
