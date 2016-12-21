<?php

namespace GC\Model;

use GC\Model\ModuleFile;
use GC\Model\ModuleItem;
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

    protected static function deleteModuleByPrimaryId($primary_id)
    {
        static::deleteByPrimaryId($primary_id);
        ModuleFile::deleteUnassignedByForeign();
        ModuleItem::deleteUnassignedByForeign();
    }

    protected static function deleteModuleByForeign($foreign_id)
    {
        static::deleteAllByForeign($foreign_id);
        ModuleFile::deleteUnassignedByForeign();
        ModuleItem::deleteUnassignedByForeign();
    }

    protected static function insertWithFrameId(array $data, $frame_id)
    {
        $module_id = parent::insert($data);

        ModulePosition::insert([
            'frame_id' => $frame_id,
            'module_id' => $module_id,
            'position' => '0:10:12:1',
        ]);

        return $module_id;
    }
}
