<?php

class Menu extends Node
{
    public static $cache = [];
    public static $primaryIdLabel = "menu_id";
    public static $parentIdLabel  = "parent_id";

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
    public static function buildTreeByGroupId($group_id)
    {
        $flatList = NavMenuModel::selectNodesByGroupId($group_id);
        $tree = static::createTree($flatList);

        return $tree;
    }

    /**
     * Na podstawie workname i języka odpowiednio pobiera właściwą nawigację i buduje z niej drzewo
     */
    public static function buildTree($workname, $language)
    {
        if (empty(self::$cache)) {
            $navs = NavModel::selectAll();
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

        $flatList = NavMenuModel::selectNodesByGroupId($group_id);
        $tree = static::createTree($flatList);

        return $tree;
    }
}
