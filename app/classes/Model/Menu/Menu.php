<?php

namespace GC\Model\Menu;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\NodeTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\AbstractNode;
use GC\Container;
use GC\Url;

class Menu extends AbstractNode
{
    public static $table        = '::menus';
    public static $primary      = 'menu_id';
    public static $treeTable    = '::menu_tree';
    public static $taxonomy     = 'nav_id';

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
            $href = Url::root("/");
        }

        if ($this->type === 'page') {
            $href = Url::root("/page/".$this->destination);
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
        $nav = Taxonomy::select()
            ->equals('workname', $workname)
            ->equals('lang', $lang)
            ->fetch();

        $tree = static::buildTreeByTaxonomyId($nav['nav_id']);

        return $tree;
    }

    public static function insertWithNavId(array $data, $nav_id)
    {
        $menu_id = parent::insert($data);

        Tree::insert([
            'nav_id' => $nav_id,
            'menu_id' => $menu_id,
            'parent_id' => null,
            'position' => Tree::selectMaxPositionByTaxonomyIdAndParentId($nav_id, null),
        ]);

        return $menu_id;
    }
}
