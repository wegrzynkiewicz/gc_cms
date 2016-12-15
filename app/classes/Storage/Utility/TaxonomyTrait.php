<?php

namespace GC\Storage\Utility;

use GC\Storage\Database;

trait TaxonomyTrait
{
    public static $cache = [];

    /**
     * Na podstawie workname i języka odpowiednio pobiera właściwą taksonomię
     */
    public static function selectSingleByWorkName($workname, $lang)
    {
        $workname .= "_$lang";
        if (empty(self::$cache)) {
            $taxonomies = static::selectAllWithPrimaryKey();
            foreach ($taxonomies as $tax_id => $taxonomy) {
                $name = $taxonomy['workname'].'_'.$taxonomy['lang'];
                self::$cache[$name] = $taxonomy;
            }
        }

        $taxonomy = self::$cache[$workname];

        return $taxonomy;
    }
}
