<?php

namespace GC\Model\Menu;

use GC\Storage\AbstractNode;

class Menu extends AbstractNode
{
    public static $table        = '::menus';
    public static $primary      = 'menu_id';
    public static $node         = 'menu_id';
    public static $fields       = 'parent_id, ::menus.*, slug, ::frames.name AS frame_name';
    public static $tree         = '::menus LEFT JOIN ::menu_tree USING (menu_id)';
    public static $tree_frame   = '::menus LEFT JOIN ::menu_tree USING (menu_id) LEFT JOIN ::frames USING (frame_id)';
    public static $aloneNodes   = '::menu_tree RIGHT JOIN ::menus USING(menu_id)';

    /**
     * Zwraca poprawną nazwę
     */
    public function getName()
    {
        if ($this->name) {
            return $this->name;
        }

        if ($this->frame_name) {
            return $this->frame_name;
        }

        return $GLOBALS['trans']('(Bez nazwy)');
    }

    /**
     * Zwraca odpowiedni adres docelowego odnośnika
     */
    public function getSlug()
    {
        if ($this->type === 'homepage') {
            return $GLOBALS['uri']->root('/');
        }

        if ($this->type === 'external') {
            return $this->destination;
        }

        if ($this->slug) {
            return $this->slug;
        }

        $slug = normalizeSlug($this->frame_name.'/'.$this->frame_id);

        return $slug;
    }

    /**
     * Usuwa węzeł i wszystkie węzły potomne
     */
    public static function deleteByMenuId($menu_id)
    {
        # usuń węzeł nawigacji
        static::deleteByPrimaryId($menu_id);

        # pobierz węzły nawigacji, które nie są przypisane do drzewa
        $nodes = static::select()
            ->fields(['menu_id'])
            ->source('::aloneNodes')
            ->equals('nav_id', null)
            ->fetchAll();

        # usuń każdy samotny węzeł nawigacji
        foreach ($nodes as $node) {
            static::deleteByPrimaryId($node['menu_id']);
        }
    }
}
