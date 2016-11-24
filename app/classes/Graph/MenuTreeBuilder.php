<?php

class MenuTreeBuilder extends AbstractTreeBuilder
{
    private $cache = [];

    public function __construct()
    {
        parent::__construct('menu_id', 'parent_id');

        $navs = NavModel::selectAll();
        foreach ($navs as $group_id => $nav) {
            $name = $nav['workname'].'_'.$nav['lang'];
            $this->cache[$name] = $group_id;
        }
    }

    public function buildTreeByGroupId($group_id)
    {
        $flatList = NavMenuModel::selectNodesByGroupId($group_id);
        $nodes = $this->createTree($flatList);

        return $nodes;
    }

    public function buildTree($workname, $language)
    {
        $name = $workname.'_'.$language;
        if (!isset($this->cache[$name])) {
            trigger_error("Nav not found $name");
            return;
        }
        $group_id = $this->cache[$name];

        $flatList = NavMenuModel::selectNodesByGroupId($group_id);
        $nodes = $this->createTree($flatList);

        return $nodes;
    }
}
