<?php

namespace GrafCenter\CMS\Model;

use GrafCenter\CMS\Storage\AbstractModel;
use GrafCenter\CMS\Storage\Utility\PrimaryTrait;
use GrafCenter\CMS\Storage\Utility\TaxonomyTrait;
use GrafCenter\CMS\Storage\Database;

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
