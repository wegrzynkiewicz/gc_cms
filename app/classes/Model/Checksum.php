<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Data;

class Checksum extends AbstractModel
{
    public static $table       = '::checksums';
    public static $primary     = 'file';

    use PrimaryTrait;
}
