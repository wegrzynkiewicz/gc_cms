<?php

namespace GC\Model\Module;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\JoinTrait;
use GC\Storage\Utility\ContainFrameTrait;
use GC\Container;

class Item extends AbstractModel
{
    public static $table       = '::module_items';
    public static $primary     = 'item_id';
    public static $joinTable   = '::module_item_pos';
    public static $joinForeign = 'module_id';

    use PrimaryTrait;
    use JoinTrait;
    use ContainFrameTrait;

    public static function deleteItemsByForeign($module_id)
    {
        $items = static::joinAllWithKeyByForeign($module_id);
        foreach ($items as $item_id => $item) {
            static::deleteFrameByPrimaryId($item_id);
        }
        static::deleteAllByForeign($module_id);
    }

    public static function insertWithModuleId(array $data, $module_id)
    {
        $item_id = parent::insert($data);

        ItemPosition::insert([
            'module_id' => $module_id,
            'item_id' => $item_id,
            'position' => ItemPosition::selectMaxPositionBy('module_id', $module_id),
        ]);

        return $item_id;
    }
}
