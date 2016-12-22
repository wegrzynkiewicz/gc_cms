<?php

namespace GC\Storage\Utility;

use GC\Storage\Database;

trait TaxonomyTrait
{
    /**
     * Na podstawie workname i języka odpowiednio pobiera właściwą taksonomię
     */
    public static function selectSingleByWorkName($workname, $lang)
    {
        $sql = self::sql("SELECT * FROM ::table WHERE lang = ? AND workname = ? LIMIT 1");
        $row = Database::fetchSingle($sql, [$workname, $lang]);

        return $row;
    }
}
