<?php

namespace GCC\Model;

use GCC\Storage\AbstractModel;
use GCC\Storage\Utility\ColumnTrait;
use GCC\Storage\Utility\PrimaryTrait;
use GCC\Storage\Database;

class Widget extends AbstractModel
{
    public static $cache   = [];
    public static $table   = '::widgets';
    public static $primary = 'widget_id';

    use ColumnTrait;
    use PrimaryTrait;

    /**
     * Pobiera wszystkie widzety z danego języka, gdzie kluczem jest widget_id
     */
    public static function selectAllCorrectWitPrimaryId()
    {
        $sql = self::sql("SELECT * FROM ::table WHERE ::lang ORDER BY name ASC");
        $rows = Database::fetchAllWithKey($sql, [], static::$primary);

        return $rows;
    }

    /**
     * Pobiera wszystkie widzety z danego języka, gdzie kluczem jest workname
     */
    public static function selectAllCorrectWithWorkName()
    {
        $sql = self::sql("SELECT * FROM ::table WHERE ::lang ORDER BY name ASC");
        $rows = Database::fetchAllWithKey($sql, [], 'workname');

        return $rows;
    }

    /**
     * Na podstawie workname odpowiednio pobiera widget, wykorzystuje cache
     */
    public static function selectSingleByWorkName($workname)
    {
        if (empty(self::$cache)) {
            $widgets = static::selectAllCorrectWithWorkName();
            foreach ($widgets as $name => $widget) {
                self::$cache[$name] = $widget;
            }
        }

        $widget = self::$cache[$workname];

        return $widget;
    }
}
