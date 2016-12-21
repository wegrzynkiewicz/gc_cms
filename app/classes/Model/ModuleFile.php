<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\JoinTrait;
use GC\Storage\Database;

class ModuleFile extends AbstractModel
{
    public static $table       = '::module_files';
    public static $primary     = 'file_id';
    public static $joinTable   = '::module_file_pos';
    public static $joinForeign = 'module_id';

    use ColumnTrait;
    use PrimaryTrait;
    use JoinTrait;

    protected static function insertWithModuleId(array $data, $module_id)
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
