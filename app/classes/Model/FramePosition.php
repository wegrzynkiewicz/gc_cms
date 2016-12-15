<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Database;

class FramePosition extends AbstractModel
{
    public static $table = '::frame_pos';

    use ColumnTrait;

    protected static function updateGridByFrameId($frame_id, array $positions)
    {
        FramePosition::deleteAllBy('frame_id', $frame_id);

        foreach ($positions as $module) {

            $grid = implode(':', [
                $module['x'],
                $module['y'],
                $module['width'],
                $module['height'],
            ]);

            FramePosition::insert([
                'frame_id' => $frame_id,
                'module_id' => $module['id'],
                'grid' => $grid,
            ]);
        }
    }
}
