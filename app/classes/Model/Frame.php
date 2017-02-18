<?php

namespace GC\Model;

use GC\Validate;
use GC\Model\Module\Module;
use GC\Storage\AbstractModel;

class Frame extends AbstractModel
{
    public static $table   = '::frames';
    public static $primary = 'frame_id';

    public static function updateByFrameId($frame_id, array $data)
    {
        $data['modify_datetime'] = sqldate();
        if (isset($data['slug']) and empty($data['slug'])) {
            $data['slug'] = static::proposeSlug($data['name']);
        }

        return static::updateByPrimaryId($frame_id, $data);
    }

    public static function insert(array $data)
    {
        $data['creation_datetime'] = sqldate();
        $data['modify_datetime'] = sqldate();
        if (isset($data['slug']) and empty($data['slug'])) {
            $data['slug'] = static::proposeSlug($data['name']);
        }

        return parent::insert($data);
    }

    /**
     * Zwraca wolny slug, lub pusty jeżeli jego brak
     */
    public static function proposeSlug($name)
    {
        $proposedSlug = normalizeSlug($name);
        if (Validate::slug($proposedSlug)) {
            return $proposedSlug;
        }

        $number = 1;
        while (true) {
            $proposedSlug = normalizeSlug($name.'/'.intval($number));
            if (Validate::slug($proposedSlug)) {
                return $proposedSlug;
            }
            $number++;
        }

        return '';
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
