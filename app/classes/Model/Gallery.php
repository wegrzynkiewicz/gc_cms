<?php

namespace GrafCenter\CMS\Model;

use GrafCenter\CMS\Storage\AbstractModel;
use GrafCenter\CMS\Storage\Utility\ColumnTrait;
use GrafCenter\CMS\Storage\Utility\PrimaryTrait;
use GrafCenter\CMS\Storage\Database;

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
