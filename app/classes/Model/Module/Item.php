<?php

namespace GC\Model\Module;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\JoinTrait;
use GC\Storage\Utility\ContainFrameTrait;
use GC\Data;

class Item extends AbstractModel
{
    public static $table       = '::module_items';
    public static $primary     = 'item_id';
    public static $joinTable   = '::module_item_pos';
    public static $joinForeign = 'module_id';
    public static $frame       = '::module_items JOIN ::frames USING (frame_id)';

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
}
