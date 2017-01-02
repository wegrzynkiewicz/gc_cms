<?php

namespace GC\Model\Product;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Database;

class Taxonomy extends AbstractModel
{
    public static $table   = '::product_taxonomies';
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
