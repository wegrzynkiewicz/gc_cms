<?php

namespace GC\Model;

use GC\Staff;
use GC\Validate;
use GC\Model\Module;
use GC\Storage\AbstractModel;

class Frame extends AbstractModel
{
    public static $table   = '::frames';
    public static $primary = 'frame_id';

    public static function updateByFrameId($frame_id, array $data)
    {
        $lang = Staff::getInstance()->getEditorLang();
        $data['modification_datetime'] = sqldate();
        if (isset($data['slug']) and empty($data['slug'])) {
            $data['slug'] = static::proposeSlug($data['name'], $lang, $frame_id);
        }

        return static::updateByPrimaryId($frame_id, $data);
    }

    public static function insert(array $data)
    {
        $lang = Staff::getInstance()->getEditorLang();
        $data['creation_datetime'] = sqldate();
        $data['modification_datetime'] = sqldate();
        $data['lang'] = $lang;
        if (isset($data['slug']) and empty($data['slug'])) {
            $data['slug'] = static::proposeSlug($data['name'], $lang);
        }

        return parent::insert($data);
    }

    /**
     * Zwraca wolny slug, lub pusty jeżeli jego brak
     */
    public static function proposeSlug($name, $lang, $frame_id = 0)
    {
        $proposedSlug = normalizeSlug($name);

        if ($lang !== $GLOBALS['config']['lang']['main']) {
            $proposedSlug = "/{$lang}{$proposedSlug}";
        }

        if (Validate::slug($proposedSlug, $frame_id)) {
            return $proposedSlug;
        }

        $number = 1;
        while (true) {
            $slug = $proposedSlug.'/'.intval($number);
            if (Validate::slug($slug, $frame_id)) {
                return $slug;
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
