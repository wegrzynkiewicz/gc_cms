<?php

class MenuTaxonomy extends Model
{
    public static $table   = '::menu_taxonomies';
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
