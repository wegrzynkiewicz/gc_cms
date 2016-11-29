<?php

class Gallery extends Model
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
        $rows = Database::fetchAllWithPrimaryId($sql, [], static::$primary);

        return $rows;
    }
}
