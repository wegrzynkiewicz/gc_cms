<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\ContainFrameTrait;
use GC\Storage\Database;

class ModuleItem extends AbstractModel
{
    public static $table   = '::module_items';
    public static $primary = 'item_id';

    use ColumnTrait;
    use PrimaryTrait;
    use ContainFrameTrait;

    public static function selectAllByModuleId($module_id)
    {
        $sql = self::sql("SELECT * FROM ::table LEFT JOIN ::module_item_pos AS p USING (::primary) WHERE p.module_id = ? ORDER BY position ASC");
        $rows = Database::fetchAllWithKey($sql, [intval($module_id)], static::$primary);

        return $rows;
    }

    public static function selectAllWithFrameByModuleId($module_id)
    {
        $sql = self::sql("SELECT * FROM ::table LEFT JOIN ::frames USING (frame_id) LEFT JOIN ::module_item_pos AS p USING (::primary) WHERE p.module_id = ? ORDER BY position ASC");
        $rows = Database::fetchAllWithKey($sql, [intval($module_id)], static::$primary);

        return $rows;
    }

    protected static function deleteAllByModuleId($module_id)
    {
        $sql = self::sql("DELETE t FROM ::table AS t LEFT JOIN ::module_item_pos AS p USING (::primary) WHERE p.module_id = ?");
        $affectedRows = Database::execute($sql, [intval($module_id)]);

        return $affectedRows;
    }

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
