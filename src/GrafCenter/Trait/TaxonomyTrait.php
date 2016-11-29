<?php

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
                $name .= '_'.$taxonomy['lang'];
                self::$cache[$name] = $taxonomy;
            }
        }

        $taxonomy = self::$cache[$workname];

        return $taxonomy;
    }
}
