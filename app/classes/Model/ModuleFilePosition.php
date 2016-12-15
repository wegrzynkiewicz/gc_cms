<?php

namespace GrafCenter\CMS\Model;

use GrafCenter\CMS\Storage\AbstractModel;
use GrafCenter\CMS\Storage\Utility\ColumnTrait;
use GrafCenter\CMS\Storage\Utility\PositionTrait;
use GrafCenter\CMS\Storage\Database;

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
