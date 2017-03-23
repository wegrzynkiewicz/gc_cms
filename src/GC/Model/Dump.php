<?php

declare(strict_types=1);

namespace GC\Model;

use GC\Storage\AbstractModel;

class Dump extends AbstractModel
{
    public static $table       = '::dumps';
    public static $primary     = 'dump_id';
}
