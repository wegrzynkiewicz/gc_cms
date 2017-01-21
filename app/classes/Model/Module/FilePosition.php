<?php

namespace GC\Model\Module;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PositionTrait;
use GC\Data;

class FilePosition extends AbstractModel
{
    public static $table = '::module_file_pos';

    use PositionTrait;
}
