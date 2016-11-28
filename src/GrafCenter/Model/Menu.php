<?php

class Menu extends Node
{
    public static $table   = '::nav_menus';
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
        $sql = self::sql("SELECT * FROM ::table AS n LEFT JOIN ::nav_positions AS p USING (::primary) WHERE p.nav_id = ? ORDER BY position ASC");
        $nodes =  Database::fetchAllWithPrimaryId($sql, [$nav_id], static::$primary);
        $tree = static::createTree($nodes);

        return $tree;
    }

    /**
     * Na podstawie workname i języka odpowiednio pobiera właściwą nawigację i buduje z niej drzewo
     */
    public static function buildTree($workname, $language)
    {
        if (empty(self::$cache)) {
            $navs = Nav::selectAllWithPrimaryKey();
            foreach ($navs as $group_id => $nav) {
                $name = $nav['workname'].'_'.$nav['lang'];
                self::$cache[$name] = $group_id;
            }
        }

        $name = $workname.'_'.$language;
        if (!isset(self::$cache[$name])) {
            trigger_error("Nav not found $name");
            return;
        }
        $group_id = self::$cache[$name];

        $tree = static::buildTreeByNavId($group_id);

        return $tree;
    }

    /**
     * Usuwa węzły, które nie należą do żadnej grupy i nie posiadają rodzica
     */
    protected static function deleteWithoutParentId()
    {
        $sql = self::sql("DELETE n FROM ::table AS n LEFT JOIN ::nav_positions AS p USING(::primary) WHERE p.nav_id IS NULL");
        $affectedRows = Database::execute($sql);

        return $affectedRows;
    }

    protected static function insert(array $data, $nav_id)
    {
        $menu_id = parent::insert($data);

        MenuPosition::insert([
            'nav_id' => $nav_id,
            'menu_id' => $menu_id,
            'parent_id' => null,
            'position' => MenuPosition::selectMaxPositionByNavIdAndParentId($nav_id, null),
        ]);

        return $primary_id;
    }
}
