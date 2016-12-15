<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PositionTrait;
use GC\Storage\Database;

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
