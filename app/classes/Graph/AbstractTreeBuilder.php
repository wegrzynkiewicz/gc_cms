<?php

abstract class AbstractTreeBuilder
{
    private $primaryIdLabel;
    private $parentIdLabel;

    public function __construct($primaryIdLabel, $parentIdLabel)
    {
        $this->primaryIdLabel = $primaryIdLabel;
        $this->parentIdLabel = $parentIdLabel;
    }

    protected function createTree(array $list)
    {
        $rootNode = new Node([]);

        if (count($list) > 0) {
            $nodes = [];
            $parents = [];
            foreach ($list as $entity) {
                $node = new Node($entity);
                $id = intval($entity[$this->primaryIdLabel]);
                $pid = intval($entity[$this->parentIdLabel]);
                $nodes[$id] = $node;
                $parents[$pid][$id] = $node;
            }
            $rootNode->pushChildren($this->createBranch($parents, $parents[0]));
        }

        return $rootNode;
    }

    protected function createBranch(&$allChildrenOfParents, $childrenOfNode)
    {
        $tree = [];
        foreach ($childrenOfNode as $child) {
            $id = $child->{$this->primaryIdLabel};
            if (isset($allChildrenOfParents[$id])) {
                $child->pushChildren($this->createBranch(
                    $allChildrenOfParents, $allChildrenOfParents[$id]
                ));
            }
            $tree[] = $child;
        }

        return $tree;
    }
}
