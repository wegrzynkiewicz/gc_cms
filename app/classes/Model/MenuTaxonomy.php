<?php

namespace GCC\Model;

use GCC\Storage\AbstractModel;
use GCC\Storage\Utility\PrimaryTrait;
use GCC\Storage\Utility\TaxonomyTrait;
use GCC\Storage\Database;

class MenuTaxonomy extends AbstractModel
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
