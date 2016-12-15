<?php

namespace GrafCenter\CMS\Model;

use GrafCenter\CMS\Storage\AbstractModel;
use GrafCenter\CMS\Storage\Utility\ColumnTrait;
use GrafCenter\CMS\Storage\Utility\PrimaryTrait;
use GrafCenter\CMS\Storage\Database;

class ModuleFile extends AbstractModel
{
    public static $table   = '::module_files';
    public static $primary = 'file_id';

    use ColumnTrait;
    use PrimaryTrait;

    public static function selectAllByModuleId($module_id)
    {
        $sql = self::sql("SELECT * FROM ::table LEFT JOIN ::module_file_pos AS p USING (::primary) WHERE p.module_id = ? ORDER BY position ASC");
        $rows = Database::fetchAllWithKey($sql, [intval($module_id)], static::$primary);

        return $rows;
    }

    protected static function deleteAllByModuleId($module_id)
    {
        $sql = self::sql("DELETE t FROM ::table AS t LEFT JOIN ::module_file_pos AS p USING (::primary) WHERE p.module_id = ?");
        $affectedRows = Database::execute($sql, [intval($module_id)]);

        return $affectedRows;
    }

    protected static function insert(array $data, $module_id)
    {
        $file_id = parent::insert($data);

        ModuleFilePosition::insert([
            'module_id' => $module_id,
            'file_id' => $file_id,
            'position' => ModuleFilePosition::selectMaxPositionBy('module_id', $module_id),
        ]);

        return $file_id;
    }
}
