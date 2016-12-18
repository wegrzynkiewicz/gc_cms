<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Database;

class Form extends AbstractModel
{
    public static $table   = '::forms';
    public static $primary = 'form_id';

    use ColumnTrait;
    use PrimaryTrait;

    /**
     * Pobiera wszystkie formularze z danego języka
     */
    public static function selectAllCorrectWithPrimaryKey()
    {
        $sql = self::sql("SELECT * FROM ::table WHERE ::lang ORDER BY name ASC");
        $rows = Database::fetchAllWithKey($sql, [], static::$primary);

        return $rows;
    }

    /**
     * Pobiera wszystkie formularze z danego języka i zapisuje je w prostej tablicy $primary_id => $column
     */
    public static function selectAllOptionsWithPrimaryKey($column)
    {
        $sql = self::sql("SELECT * FROM ::table WHERE ::lang ORDER BY name ASC");
        $rows = Database::fetchAsOptionsWithPrimaryId($sql, [], static::$primary, $column);

        return $rows;
    }
}
