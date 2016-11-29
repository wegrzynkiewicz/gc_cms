<?php

class Nav extends Model
{
    public static $table   = '::navs';
    public static $primary = 'nav_id';

    use PrimaryTrait;

    /**
     * Pobiera wszystkie nawigacje z danego języka
     */
    public static function selectAllCorrectWithPrimaryKey()
    {
        $sql = self::sql("SELECT * FROM ::table WHERE ::lang ORDER BY name ASC");
        $rows = Database::fetchAllWithKey($sql, [], static::$primary);

        return $rows;
    }
}
