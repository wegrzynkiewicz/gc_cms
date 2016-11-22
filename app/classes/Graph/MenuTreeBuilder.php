<?php

class MenuTreeBuilder extends AbstractTreeBuilder
{
    private $cache = [];

    public function __construct()
    {
        parent::__construct('node_id', 'parent_id');

        $navs = NavModel::selectAll();
        foreach ($navs as $nav_id => $nav) {
            $name = $nav['workname'].'_'.$nav['lang'];
            $this->cache[$name] = $nav_id;
        }
    }

    public function buildTree($workname, $language)
    {
        $name = $workname.'_'.$language;
        if (!isset($this->cache[$name])) {
            trigger_error("Nav not found $name");
            return;
        }
        $nav_id = $this->cache[$name];

        $flatList = NavNodeModel::selectNodesByGroupId($nav_id);
        $nodes = $this->createTree($flatList);

        return $nodes;
    }
}
