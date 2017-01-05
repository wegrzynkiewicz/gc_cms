<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Database;

class Dump extends AbstractModel
{
    public static $table       = '::dumps';
    public static $primary     = 'dump_id';

    use PrimaryTrait;
}
