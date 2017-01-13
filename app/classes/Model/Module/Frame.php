<?php

namespace GC\Model\Module;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Container;

class Frame extends AbstractModel
{
    public static $table   = '::frames';
    public static $primary = 'frame_id';

    use ColumnTrait;
    use PrimaryTrait;

    public static function updateByFrameId($frame_id, array $data)
    {
        $data['modify_datetime'] = sqldate();

        return parent::updateByPrimaryId($frame_id, $data);
    }

    public static function insert(array $data)
    {
        $data['creation_datetime'] = sqldate();
        $data['modify_datetime'] = sqldate();
        $data['lang'] = $_SESSION['lang']['editor'];
        $data['settings'] = json_encode([]);

        return parent::insert($data);
    }
}
