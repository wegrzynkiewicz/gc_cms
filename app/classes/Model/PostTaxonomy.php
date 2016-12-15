<?php

class PostTaxonomy extends Model
{
    public static $table   = '::post_taxonomies';
    public static $primary = 'tax_id';

    use ColumnTrait;
    use PrimaryTrait;

    /**
     * Pobiera wszystkie podziały wpisów z danego języka
     */
    public static function selectAllCorrectWithPrimaryKey()
    {
        $sql = self::sql("SELECT * FROM ::table WHERE ::lang ORDER BY name ASC");
        $rows = Database::fetchAllWithKey($sql, [], static::$primary);

        return $rows;
    }
}