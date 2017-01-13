<?php

namespace GC\Model\Module;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PositionTrait;
use GC\Container;

class ItemPosition extends AbstractModel
{
    public static $table = '::module_item_pos';

    use PositionTrait;

    public static function updatePositionsByModuleId($module_id, array $positions)
    {
        static::delete()->equals('module_id', $module_id)->execute();

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
