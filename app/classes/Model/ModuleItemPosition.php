<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PositionTrait;
use GC\Storage\Database;

class ModuleItemPosition extends AbstractModel
{
    public static $table = '::module_item_pos';

    use ColumnTrait;
    use PositionTrait;

    protected static function updatePositionsByModuleId($module_id, array $positions)
    {
        static::deleteAllBy('module_id', $module_id);

        $pos = 1;
        foreach ($positions as $item) {
            static::insert([
                'module_id' => $module_id,
                'item_id' => $item['id'],
                'position' => $pos++,
            ]);
        }
    }
}
