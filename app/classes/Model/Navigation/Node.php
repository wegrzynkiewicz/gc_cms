<?php

namespace GC\Model\Navigation;

use GC\Storage\AbstractNode;

class Node extends AbstractNode
{
    public static $table        = '::navigation_nodes';
    public static $primary      = 'node_id';
    public static $nodeIndex    = 'node_id';
    public static $tree         = '::navigation_nodes LEFT JOIN ::navigation_tree USING (node_id)';
    public static $withFrameFields = '::navigation_nodes.*, parent_id, ::frames.slug, ::frames.name AS frame_name, ::frames.type AS frame_type';
    public static $withFrameSource = '::navigation_nodes LEFT JOIN ::navigation_tree USING (node_id) LEFT JOIN ::frames USING (frame_id)';
    public static $aloneNodes   = '::navigation_tree RIGHT JOIN ::navigation_nodes USING(node_id)';

    /**
     * Zwraca poprawną nazwę
     */
    public function getName()
    {
        if (isset($this->name) and $this->name) {
            return $this->name;
        }

        if (isset($this->frame_name) and $this->frame_name) {
            return $this->frame_name;
        }

        return '';
    }

    /**
     * Zwraca odpowiedni adres docelowego odnośnika
     */
    public function getHref()
    {
        if ($this->type === 'empty') {
            return '#';
        }

        if ($this->type === 'frame' and $this->frame_id) {
            return $GLOBALS['uri']->make($this->slug);
        }

        if ($this->type === 'homepage') {
            return $GLOBALS['uri']->make('/');
        }

        if ($this->type === 'external') {
            return $this->destination;
        }

        return '#';
    }

    /**
     * Usuwa węzeł i wszystkie węzły potomne
     */
    public static function deleteByNodeId($node_id)
    {
        # usuń węzeł nawigacji
        static::deleteByPrimaryId($node_id);

        # pobierz węzły nawigacji, które nie są przypisane do drzewa
        $nodes = static::select()
            ->fields(['node_id'])
            ->source('::aloneNodes')
            ->equals('navigation_id', null)
            ->fetchByPrimaryKey();

        # usuń każdy samotny węzeł nawigacji
        foreach ($nodes as $node_id => $node) {
            static::deleteByPrimaryId($node_id);
        }
    }
}
