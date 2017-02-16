<?php

namespace GC\Model;

use GC\Model\Module\Module;
use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;

class Frame extends AbstractModel
{
    public static $table   = '::frames';
    public static $primary = 'frame_id';

    use PrimaryTrait;

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
    public static function deleteFrameByPrimaryId($primary_id)
    {
        # pobierz informacje o rusztowaniu o id głownym
        $row = static::fetchByPrimaryId($primary_id);

        # usuń wszystkie moduły dla rusztowania o frame_id
        Module::deleteModulesByForeign($row['frame_id']);

        # usuń wszystkie moduły, które nie są przypisane do rusztowań
        Module::deleteUnassignedByForeign();

        # usuń rusztowanie o id głownym (strony)
        Frame::deleteByPrimaryId($row['frame_id']);

        # usuń (stronę) o id głownym
        static::deleteByPrimaryId($primary_id);
    }
}
