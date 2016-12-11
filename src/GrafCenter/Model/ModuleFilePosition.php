<?php

class ModuleFilePosition extends Model
{
    public static $table = '::module_file_pos';

    use ColumnTrait;
    use PositionTrait;

    protected static function updatePositionsByModuleId($module_id, array $positions)
    {
        static::deleteAllBy('module_id', $module_id);

        $pos = 1;
        foreach ($positions as $file_id) {
            static::insert([
                'module_id' => $module_id,
                'file_id' => $file_id,
                'position' => $pos++,
            ]);
        }
    }
}
