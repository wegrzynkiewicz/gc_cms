<?php

namespace GC\Model\Module;

use GC\Storage\AbstractModel;
use GC\Data;

class Position extends AbstractModel
{
    public static $table = '::module_pos';

    public static function updateGridByFrameId($frame_id, array $positions)
    {
        Position::delete()->equals('frame_id', $frame_id)->execute();

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
