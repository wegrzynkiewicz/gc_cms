<?php

namespace GC\Model\Menu;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\TaxonomyTrait;
use GC\Storage\Database;

class Taxonomy extends AbstractModel
{
    public static $table     = '::menu_taxonomies';
    public static $primary   = 'nav_id';

    use PrimaryTrait;
    use TaxonomyTrait;

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
