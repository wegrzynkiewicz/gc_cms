<?php

namespace GC\Model\Module;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Database;

class Position extends AbstractModel
{
    public static $table = '::module_pos';

    use ColumnTrait;

    public static function updateGridByFrameId($frame_id, array $positions)
    {
        Position::deleteAllBy('frame_id', $frame_id);

        foreach ($positions as $module) {

            $grid = implode(':', [
                $module['x'],
                $module['y'],
                $module['width'],
                $module['height'],
            ]);

            Position::insert([
                'frame_id' => $frame_id,
                'module_id' => $module['id'],
                'position' => $grid,
            ]);
        }
    }
}
