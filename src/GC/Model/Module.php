<?php

declare(strict_types=1);

namespace GC\Model;

use GC\Model\Frame;
use GC\Model\File;
use GC\Model\Module\Tab;
use GC\Model\Module\FileRelation;
use GC\Storage\AbstractModel;

class Module extends AbstractModel
{
    public static $table = '::modules';
    public static $primary = 'module_id';
    public static $grid = '::modules LEFT JOIN ::module_grid USING (module_id)';

    /**
     * Usuwa moduł i wszystkie jego pliki i zakładki
     */
    public static function deleteByModuleId(int $module_id): void
    {
        // pobierz zakładki tego modułu
        $tabs = Tab::select()
            ->fields('frame_id')
            ->source('::frame')
            ->equals('module_id', $module_id)
            ->fetchAll();

        // dla każdej zakładki usuń rusztowanie
        foreach ($tabs as $tab) {
            Frame::deleteByFrameId($tab['frame_id']);
        }

        // pobierz pliki tego modułu
        $files = FileRelation::select()
            ->fields('file_id')
            ->source('::files')
            ->equals('module_id', $module_id)
            ->fetchAll();

        // dla każdego pliku usuń rusztowanie
        foreach ($files as $file) {
            File::deleteByPrimaryId($file['file_id']);
        }

        // usuń właściwy moduł
        static::deleteByPrimaryId($module_id);
    }

    /**
     * Usuwa moduły i ich dodatki dla całego rusztowania
     */
    public static function deleteByFrameId(int $frame_id): void
    {
        // pobierz wszystkie moduły
        $modules = static::select()
            ->source('::grid')
            ->equals('frame_id', $frame_id)
            ->fetchByPrimaryKey();

        // dla każdego modułu usuń jego dodatki
        foreach ($modules as $module_id => $modules) {
            static::deleteByModuleId($module_id);
        }
    }
}
