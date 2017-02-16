<?php

namespace GC\Model\Module;

use GC\Storage\AbstractModel;

class File extends AbstractModel
{
    public static $table = '::module_files';
    public static $frame = '::module_files JOIN ::frames USING (frame_id)';

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
