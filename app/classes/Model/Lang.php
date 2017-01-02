<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\OrderTrait;
use GC\Storage\Database;

class Lang extends AbstractModel
{
    public static $table       = '::langs';
    public static $primary     = 'code';

    use PrimaryTrait;
    use OrderTrait;
}
