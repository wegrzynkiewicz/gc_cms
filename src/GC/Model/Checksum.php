<?php

namespace GC\Model;

use GC\Storage\AbstractModel;

class Checksum extends AbstractModel
{
    public static $table       = '::checksums';
    public static $primary     = 'file';
}