<?php

namespace GC\Model\Module;

use GC\Model\Module\File;
use GC\Model\Module\Item;
use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\JoinTrait;
use GC\Storage\Database;

class Module extends AbstractModel
{
    public static $table       = '::modules';
    public static $primary     = 'module_id';
    public static $joinTable   = '::module_pos';
    public static $joinForeign = 'frame_id';

    use PrimaryTrait;
    use JoinTrait;

    protected static function deleteModuleByPrimaryId($module_id)
    {
        static::deleteByPrimaryId($module_id);
        File::deleteUnassignedByForeign();
        Item::deleteItemsByForeign($module_id);
        Item::deleteUnassignedByForeign();
    }

    protected static function deleteModulesByForeign($frame_id)
    {
        $modules = static::joinAllWithKeyByForeign($frame_id);
        foreach ($modules as $module_id => $module) {
            Item::deleteItemsByForeign($module_id);
        }
        static::deleteAllByForeign($frame_id);
        File::deleteUnassignedByForeign();
        Item::deleteUnassignedByForeign();
    }

    protected static function insertWithFrameId(array $data, $frame_id)
    {
        $module_id = parent::insert($data);

        Position::insert([
            'frame_id' => $frame_id,
            'module_id' => $module_id,
            'position' => '0:999:12:1',
        ]);

        return $module_id;
    }
}
