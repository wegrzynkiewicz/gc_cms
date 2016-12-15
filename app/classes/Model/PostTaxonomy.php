<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Database;

class PostTaxonomy extends AbstractModel
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
