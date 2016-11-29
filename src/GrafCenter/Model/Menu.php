<?php

class Menu extends Node
{
    public static $table   = '::menus';
    public static $primary = 'menu_id';

    public static $cache = [];
    public static $primaryIdLabel = "menu_id";
    public static $parentIdLabel  = "parent_id";

    use PrimaryTrait;

    /**
     * Na podstawie węzła nawigacji drukuje link do strony na którą kieruje
     */
    public function getOpenTag($extend = "")
    {
        $id = sprintf('id="navNode_%s" %s', $this->menu_id, $extend);

        if ($this->type === 'empty') {
            return sprintf('<div %s>', $id);
        }

        if ($this->type === 'homepage') {
            $href = rootUrl("/");
        }

        if ($this->type === 'page') {
            $href = rootUrl("/page/".$this->destination);
        }

        if ($this->type === 'external') {
            $href = $this->destination;
        }

        return sprintf('<a %s href="%s" target="%s"> ', $id, $href, $this->target);
    }

    /**
     * Drukuje HTMLowy tag zamknięcia; używana z startlinkAttributesFromMenuNode
     */
    public function getCloseTag()
    {
        return $this->type === 'empty' ? '</div>' : '</a>';
    }

    /**
     * Pobiera właściwą nawigację po zadanym id i buduje z niej drzewo
     */
    public static function buildTreeByNavId($nav_id)
    {
        $sql = self::sql("SELECT * FROM ::table AS n LEFT JOIN ::menu_tree AS p USING (::primary) WHERE p.nav_id = ? ORDER BY position ASC");
        $nodes =  Database::fetchAllWithKey($sql, [$nav_id], static::$primary);
        $tree = static::createTree($nodes);

        return $tree;
    }

    /**
     * Na podstawie workname i języka odpowiednio pobiera właściwą nawigację i buduje z niej drzewo
     */
    public static function buildTreeByWorkName($workname, $lang)
    {
        if (empty(self::$cache)) {
            $navs = MenuTaxonomy::selectAllWithPrimaryKey();
            foreach ($navs as $nav_id => $nav) {
                $workname .= '_'.$nav['lang'];
                self::$cache[$workname] = $nav_id;
            }
        }

        $workname .= "_$lang";
        $nav_id = self::$cache[$workname];

        $tree = static::buildTreeByNavId($nav_id);

        return $tree;
    }

    /**
     * Usuwa węzły, które nie należą do żadnej grupy i nie posiadają rodzica
     */
    protected static function deleteWithoutParentId()
    {
        $sql = self::sql("DELETE n FROM ::table AS n LEFT JOIN ::menu_tree AS p USING(::primary) WHERE p.nav_id IS NULL");
        $affectedRows = Database::execute($sql);

        return $affectedRows;
    }

    protected static function insert(array $data, $nav_id)
    {
        $menu_id = parent::insert($data);

        MenuTree::insert([
            'nav_id' => $nav_id,
            'menu_id' => $menu_id,
            'parent_id' => null,
            'position' => MenuTree::selectMaxPositionByNavIdAndParentId($nav_id, null),
        ]);

        return $primary_id;
    }
}
