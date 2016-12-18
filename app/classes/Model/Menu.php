<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\NodeTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Node;
use GC\Storage\Database;

class Menu extends Node
{
    public static $table        = '::menus';
    public static $primary      = 'menu_id';
    public static $treeTable    = '::menu_tree';
    public static $taxonomy     = 'nav_id';

    public static $cache = [];
    public static $primaryIdLabel = "menu_id";
    public static $parentIdLabel  = "parent_id";

    use NodeTrait;
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
     * Na podstawie workname i języka odpowiednio pobiera właściwą nawigację i buduje z niej drzewo
     */
    public static function buildTreeByWorkName($workname, $lang)
    {
        $nav = MenuTaxonomy::selectSingleByWorkName($workname, $lang);
        $tree = static::buildTreeByTaxonomyId($nav['nav_id']);

        return $tree;
    }

    protected static function insertWithNavId(array $data, $nav_id)
    {
        $menu_id = parent::insert($data);

        MenuTree::insert([
            'nav_id' => $nav_id,
            'menu_id' => $menu_id,
            'parent_id' => null,
            'position' => MenuTree::selectMaxPositionByTaxonomyIdAndParentId($nav_id, null),
        ]);

        return $menu_id;
    }
}
