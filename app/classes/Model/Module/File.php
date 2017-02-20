<?php

namespace GC\Model\Module;

use GC\Storage\AbstractModel;

class File extends AbstractModel
{
    public static $table        = '::module_files';
    public static $primary      = 'file_id';
    public static $moduleFiles  = '::module_files LEFT JOIN ::module_file_pos USING(file_id)';
}
