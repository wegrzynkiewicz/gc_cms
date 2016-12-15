<?php

namespace GCC\Model;

use GCC\Storage\AbstractModel;
use GCC\Storage\Utility\ColumnTrait;
use GCC\Storage\Utility\PositionTrait;
use GCC\Storage\Database;

class ModuleFilePosition extends AbstractModel
{
    public static $table = '::module_file_pos';

    use ColumnTrait;
    use PositionTrait;

    protected static function updatePositionsByModuleId($module_id, array $positions)
    {
        static::deleteAllBy('module_id', $module_id);

        $pos = 1;
        foreach ($positions as $file_id) {
            static::insert([
                'module_id' => $module_id,
                'file_id' => $file_id,
                'position' => $pos++,
            ]);
        }
    }
}
