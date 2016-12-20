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
    public static function selectAllCurrentLangWithPrimaryKey()
    {
        $sql = self::sql("SELECT * FROM ::table WHERE ::lang ORDER BY name ASC");
        $rows = Database::fetchAllWithKey($sql, [], static::$primary);

        return $rows;
    }

    /**
     * Pobiera wszystkie formularze z danego języka
     */
    public static function mapCorrectWithPrimaryKeyBy($column)
    {
        Database::assertColumn($column);
        $sql = self::sql("SELECT ::primary, {$column} FROM ::table WHERE ::lang ORDER BY name ASC");
        $rows = Database::fetchMapBy($sql, [], static::$primary, $column);

        return $rows;
    }
}
