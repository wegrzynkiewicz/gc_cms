<?php

namespace GC\Model\Module;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PositionTrait;
use GC\Container;

class FilePosition extends AbstractModel
{
    public static $table = '::module_file_pos';

    use PositionTrait;

    public static function updatePositionsByModuleId($module_id, array $positions)
    {
        static::delete()->equals('module_id', $module_id)->execute();

        $pos = 1;
        foreach ($positions as $file) {
            static::insert([
                'module_id' => $module_id,
                'file_id' => $file['id'],
                'position' => $pos++,
            ]);
        }
    }
}
