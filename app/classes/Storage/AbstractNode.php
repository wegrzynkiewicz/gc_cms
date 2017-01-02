<?php

namespace GC\Storage;

use GC\Storage\AbstractModel;

/**
 * Reprezentuje węzeł w strukturze drzewiastej
 */
abstract class AbstractNode extends AbstractModel
{
    private $parent = null;
    private $children = [];

    public function getPrimaryId()
    {
        return $this->getProperty(static::$primary);
    }

    public function addChildAtPosition(AbstractNode $child, $position)
    {
        if (isset($this->children[$position])) {
            throw new UnexpectedValueException(
                sprintf('Child on position (%s) already exists', $position)
            );
        }

        $child->depriveParent();
        $this->children[$position] = $child;

        return $this;
    }

    public function countChildren()
    {
        return count($this->children);
    }

    public function countDescendants()
    {
        return count($this->getDescendants());
    }

    public function debug(array $display = [])
    {
        $getName = function ($node) use ($display) {
            $data = $node->getData();
            if (count($display)) {
                $data = [];
                foreach ($display as $field) {
                    $data[] = $node->getProperty($field, '');
                }
            }
            return implode('; ', $data);
        };

        $debug = function ($node, $structure = '') use (&$debug, $getName) {

            $children = $node->getChildren();
            $iterator = new \ArrayIterator($children);
            $structure .= empty($structure) ? '' : '   ';

            while ($iterator->valid()) {
                $child = $iterator->current();
                $iterator->next();
                $isLast = $iterator->valid();

                $childrenStructure = $structure.($isLast ? '|' : ' ');
                $nodeStructure = $structure.($isLast ? '|': '`');
                echo "\n{$nodeStructure}-- ".$getName($child);

                $debug($child, $childrenStructure);
            }
        };

        ob_start();
        echo "\n".$getName($this);
        $debug($this->getRoot());
        $buffer = ob_get_clean();

        return $buffer;
    }

    private function depriveParent()
    {
        if ($this->hasParent()) {
            $almostNoParent = $this->getParent();
            $this->parent = null;
            $almostNoParent->removeChild($this);
        }

        return $this;
    }

    public function getAncestors()
    {
        $ancestors = [];
        $node = $this;

        while ($node->hasParent()) {
            $parent = $node->getParent();
            $ancestors[] = $parent;
            $node = $parent;
        }

        return $ancestors;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getDepth()
    {
        if ($this->isRoot()) {
            return 0;
        }

        return $this->getParent()->getDepth() + 1;
    }

    public function getDescendants()
    {
        $getDescendants = function ($node, &$descendants) use (&$getDescendants) {
            foreach ($node->children as $child) {
                $descendants[] = $child;
                $getDescendants($child, $descendants);
            }
        };

        $descendants = [];
        $getDescendants($this, $descendants);

        return $descendants;
    }

    public function getHeight()
    {
        $max = 0;
        $getHeight = function ($node, $max) use (&$getHeight) {
            $currentMax = $max;
            foreach ($node->children as $child) {
                $returnedMax = $getHeight($child, $max+1);
                if ($returnedMax > $currentMax) {
                    $currentMax = $returnedMax;
                }
            }

            return $currentMax;
        };

        return $getHeight($this, $max);
    }

    public function getLevel()
    {
        return $this->getDepth() + 1;
    }

    public function getMaxDepth()
    {
        return $this->getDepth() + $this->getHeight();
    }

    public function getMaxLevel()
    {
        return $this->getMaxDepth() + 1;
    }

    public function getParent()
    {
        if ($this->parent === null) {
            throw new RuntimeException(
                "Node does not have parent"
            );
        }

        return $this->parent;
    }

    public function getRoot()
    {
        if ($this->hasParent() === false) {
            return $this;
        }

        return $this->getParent()->getRoot();
    }

    public function getSiblings()
    {
        if ($this->hasParent() === false) {
            return [];
        }

        $parent = $this->getParent();
        $siblings = [];
        foreach ($parent->getChildren() as $child) {
            if ($child !== $this) {
                $siblings[] = $child;
            }
        }

        return $siblings;
    }

    public function hasChild(AbstractNode $node)
    {
        return $this->isParentFor($node);
    }

    public function hasChildren()
    {
        return count($this->children) > 0;
    }

    public function isChildFor(AbstractNode $node)
    {
        foreach ($node->getChildren() as $child) {
            if ($this === $child) {
                return true;
            }
        }

        return false;
    }

    public function hasParent()
    {
        return $this->parent !== null;
    }

    public function isDescendantFor(AbstractNode $node)
    {
        foreach ($node->getChildren() as $child) {
            if ($this === $child) {
                return true;
            }
            if ($this->isDescendantFor($child) === true) {
                return true;
            }
        }

        return false;
    }

    public function isInner()
    {
        return $this->hasParent() and $this->hasChildren();
    }

    public function isOuter()
    {
        return $this->isRoot() or $this->isLeaf();
    }

    public function isParentFor(AbstractNode $node)
    {
        foreach ($this->children as $child) {
            if ($node === $child) {
                return true;
            }
        }

        return false;
    }

    public function isRoot()
    {
        return $this->parent === null;
    }

    public function isLeaf()
    {
        return count($this->children) == 0;
    }

    public function popChild()
    {
        if ($this->isLeaf()) {
            throw new UnderflowException(
                "Node does not have children"
            );
        }

        $child = array_pop($this->children);
        $child->depriveParent();

        return $child;
    }

    public function pushChild(AbstractNode $child)
    {
        if ($this->hasChild($child)) {
            return $this;
        }

        array_push($this->children, $child);
        $child->setParent($this);

        return $this;
    }

    public function pushChildren(array $children)
    {
        foreach ($children as $child) {
            $this->pushChild($child);
        }

        return $this;
    }

    public function removeAllChildren()
    {
        while ($this->hasChildren()) {
            $this->popChild();
        }
    }

    public function removeChild(AbstractNode $node)
    {
        foreach ($this->children as $key => $child) {
            if ($child === $node) {
                $node->depriveParent();
                unset($this->children[$key]);
                break;
            }
        }

        return $this;
    }

    public function selectFirstChildByData(array $data)
    {
        foreach ($this->getChildren() as $child) {
            if ($child->hasData($data)) {
                return $child;
            }
        }

        return null;
    }

    public function selectFirstDescendantByData(array $data)
    {
        foreach ($this->getDescendants() as $descendant) {
            if ($descendant->hasData($data)) {
                return $descendant;
            }
        }

        return null;
    }

    public function selectChildrenByData(array $data)
    {
        $correct = [];
        foreach ($this->getChildren() as $child) {
            if ($child->hasData($data)) {
                $correct[] = $child;
            }
        }

        return $correct;
    }

    public function selectDescendantsByData(array $data)
    {
        $correct = [];
        foreach ($this->getDescendants() as $descendant) {
            if ($descendant->hasData($data)) {
                $correct[] = $descendant;
            }
        }

        return $correct;
    }

    public function setParent(AbstractNode $newParent)
    {
        if ($this->hasParent() and $this->getParent() === $newParent) {
            return $this;
        }

        $this->depriveParent();
        $this->parent = $newParent;
        $this->parent->pushChild($this);

        return $this;
    }

    public function shiftChild()
    {
        if ($this->isLeaf()) {
            throw new UnderflowException(
                "Node does not have children"
            );
        }

        $child = array_shift($this->children);
        $child->depriveParent();

        return $child;
    }

    public function unshiftChild(AbstractNode $child)
    {
        if ($this->hasChild($child)) {
            return $this;
        }

        array_unshift($this->children, $child);
        $child->setParent($this);

        return $this;
    }

    public static function createTree(array $list)
    {
        $rootNode = new static([]);

        if (count($list) > 0) {
            $nodes = [];
            $parents = [];
            foreach ($list as $entity) {
                $node = new static($entity);
                $id = intval($entity[static::$primaryIdLabel]);
                $pid = intval($entity[static::$parentIdLabel]);
                $nodes[$id] = $node;
                $parents[$pid][$id] = $node;
            }
            if (isset($parents[0])) {
                $rootNode->pushChildren(static::createBranch($parents, $parents[0]));
            }
        }

        return $rootNode;
    }

    public static function createBranch(&$allChildrenOfParents, $childrenOfNode)
    {
        $tree = [];
        foreach ($childrenOfNode as $child) {
            $id = $child[static::$primaryIdLabel];
            if (isset($allChildrenOfParents[$id])) {
                $child->pushChildren(static::createBranch(
                    $allChildrenOfParents, $allChildrenOfParents[$id]
                ));
            }
            $tree[] = $child;
        }

        return $tree;
    }
}
