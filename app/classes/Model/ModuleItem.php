<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\JoinTrait;
use GC\Storage\Utility\ContainFrameTrait;
use GC\Storage\Database;

class ModuleItem extends AbstractModel
{
    public static $table       = '::module_items';
    public static $primary     = 'item_id';
    public static $joinTable   = '::module_item_pos';
    public static $joinForeign = 'module_id';

    use ColumnTrait;
    use PrimaryTrait;
    use JoinTrait;
    use ContainFrameTrait;

    protected static function insertWithModuleId(array $data, $module_id)
    {
        $item_id = parent::insert($data);

        ModuleItemPosition::insert([
            'module_id' => $module_id,
            'item_id' => $item_id,
            'position' => ModuleItemPosition::selectMaxPositionBy('module_id', $module_id),
        ]);

        return $item_id;
    }
}
