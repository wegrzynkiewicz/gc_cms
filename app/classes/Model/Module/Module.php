<?php

namespace GC\Model\Module;

use GC\Model\Frame;
use GC\Model\Module\File;
use GC\Model\Module\Tab;
use GC\Storage\AbstractModel;

class Module extends AbstractModel
{
    public static $table   = '::modules';
    public static $primary = 'module_id';
    public static $grid    = '::modules LEFT JOIN ::module_grid USING (module_id)';

    /**
     * Usuwa moduł i wszystkie jego pliki i zakładki
     */
    public static function deleteByModuleId($module_id)
    {
        # pobierz zakładki tego modułu
        $tabs = Tab::select()
            ->fields('frame_id')
            ->source('::frame')
            ->equals('module_id', $module_id)
            ->fetchAll();

        # dla każdej zakładki usuń rusztowanie
        foreach ($tabs as $tab) {
            Frame::deleteByFrameId($tab['frame_id']);
        }

        # pobierz pliki tego modułu
        $files = File::select()
            ->fields('frame_id')
            ->source('::frame')
            ->equals('module_id', $module_id)
            ->fetchAll();

        # dla każdego pliku usuń rusztowanie
        foreach ($files as $file) {
            Frame::deleteByFrameId($file['frame_id']);
        }

        # usuń właściwy moduł
        static::deleteByPrimaryId($module_id);
    }

    /**
     * Usuwa moduły i ich dodatki dla całego rusztowania
     */
    public static function deleteByFrameId($frame_id)
    {
        # pobierz wszystkie moduły
        $modules = static::select()
            ->source('::grid')
            ->equals('frame_id', $frame_id)
            ->fetchByPrimaryKey();

        # dla każdego modułu usuń jego dodatki
        foreach ($modules as $module_id => $modules) {
            static::deleteByModuleId($module_id);
        }
    }
}
