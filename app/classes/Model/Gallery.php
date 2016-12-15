<?php

namespace GCC\Model;

use GCC\Storage\AbstractModel;
use GCC\Storage\Utility\ColumnTrait;
use GCC\Storage\Utility\PrimaryTrait;
use GCC\Storage\Database;

class Gallery extends AbstractModel
{
    public static $table   = '::galleries';
    public static $primary = 'gallery_id';

    use ColumnTrait;
    use PrimaryTrait;

    /**
     * Pobiera wszystkie galerie z danego języka
     */
    public static function selectAllCorrectWithPrimaryKey()
    {
        $sql = self::sql("SELECT * FROM ::table WHERE ::lang ORDER BY name ASC");
        $rows = Database::fetchAllWithKey($sql, [], static::$primary);

        return $rows;
    }
}
