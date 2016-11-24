<?php

class FrameModuleModel extends AbstractModel
{
    public static $table      = '::frame_modules';
    public static $primary    = 'module_id';
    public static $groupTable = '::frame_positions';
    public static $groupName  = 'frame_id';

    use GroupModelTrait;

    protected static function updateGridByGroupId($group_id, array $grid)
    {
        static::deleteAllJoinsByGroupId($group_id);

        foreach ($grid as $module) {

            $position = implode(':', [
                $module['x'],
                $module['y'],
                $module['width'],
                $module['height'],
            ]);

            Database::insertDataToTable(static::$groupTable, [
                static::$groupName => $group_id,
                static::$primary => $module['id'],
                'position' => $position++,
            ]);
        }
    }
}
