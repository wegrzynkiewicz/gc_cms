<?php

namespace GC\Model;

use GC\Storage\AbstractModel;

class File extends AbstractModel
{
    public static $table        = '::files';
    public static $primary      = 'file_id';
}
