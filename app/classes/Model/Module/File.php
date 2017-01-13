<?php

namespace GC\Model\Module;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\JoinTrait;
use GC\Container;

class File extends AbstractModel
{
    public static $table       = '::module_files';
    public static $primary     = 'file_id';
    public static $joinTable   = '::module_file_pos';
    public static $joinForeign = 'module_id';

    use ColumnTrait;
    use PrimaryTrait;
    use JoinTrait;

    public static function insertWithModuleId(array $data, $module_id)
    {
        $file_id = parent::insert($data);

        FilePosition::insert([
            'module_id' => $module_id,
            'file_id' => $file_id,
            'position' => FilePosition::selectMaxPositionBy('module_id', $module_id),
        ]);

        return $file_id;
    }
}
