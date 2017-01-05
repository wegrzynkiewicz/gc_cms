<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\OrderTrait;
use GC\Storage\Database;

class Checksum extends AbstractModel
{
    public static $table       = '::checksums';
    public static $primary     = 'file';

    use PrimaryTrait;
    use ColumnTrait;
    use OrderTrait;
}
