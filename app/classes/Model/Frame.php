<?php

namespace GC\Model;

use GC\Model\Module\Module;
use GC\Storage\AbstractModel;

class Frame extends AbstractModel
{
    public static $table   = '::frames';
    public static $primary = 'frame_id';

    public static function updateByFrameId($frame_id, array $data)
    {
        $data['modify_datetime'] = sqldate();

        return static::updateByPrimaryId($frame_id, $data);
    }

    public static function insert(array $data)
    {
        $data['creation_datetime'] = sqldate();
        $data['modify_datetime'] = sqldate();

        return parent::insert($data);
    }

    /**
     * Usuwa rusztowanie i jego moduły
     */
    public static function deleteByFrameId($frame_id)
    {
        # usuń wszystkie moduły dla rusztowania o frame_id
        Module::deleteByFrameId($frame_id);

        # usuń rusztowanie o id głownym
        static::deleteByPrimaryId($frame_id);
    }
}
