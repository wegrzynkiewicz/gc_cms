<?php

namespace GC\Model\Frame;

use GC\Model\Frame;
use GC\Storage\AbstractNode;

class Tree extends AbstractNode
{
    public static $table      = '::frame_tree';
    public static $node       = 'frame_id';
    public static $nodes      = '::frame_tree LEFT JOIN ::frames USING(frame_id)';
    public static $aloneNodes = '::frame_tree RIGHT JOIN ::frames USING(frame_id)';

    /**
     *
     */
    public static function insertPositionsToTaxonomy(array $positions, $taxonomy_id)
    {
        # usuń wszystkie rekordy budujące drzewo
        static::delete()
            ->equals('taxonomy_id', $taxonomy_id)
            ->execute();

        # każdą nadesłaną pozycję wstaw do bazy danych
        foreach ($positions as $node) {

            # pobierz największą pozycję dla węzła w drzewie
            $position = static::select()
                ->fields('MAX(position) AS max')
                ->equals('taxonomy_id', $taxonomy_id)
                ->equals('parent_id', $node['parent_id'])
                ->fetch()['max'];

            static::insert([
                'frame_id' => $node['id'],
                'parent_id' => $node['parent_id'],
                'taxonomy_id' => $taxonomy_id,
                'position' => $position + 1,
            ]);
        }
    }

    /**
     *
     */
    public static function insertFrameToTaxonomy($frame_id, $taxonomy_id)
    {
        # pobierz największą pozycję dla węzła w drzewie
        $position = static::select()
            ->fields('MAX(position) AS max')
            ->equals('taxonomy_id', $taxonomy_id)
            ->equals('parent_id', null)
            ->fetch()['max'];

        # dodaj węzeł do pozycji w drzewie taksonomi
        static::insert([
            'taxonomy_id' => $taxonomy_id,
            'frame_id' => $frame_id,
            'parent_id' => null,
            'position' => $position+1,
        ]);
    }

    /**
     * Usuwa rusztowanie i wszystkie węzły potomne
     */
    public static function deleteByFrameId($frame_id)
    {
        # usuń węzeł produktu
        Frame::deleteByFrameId($frame_id);

        # pobierz węzły produktów, które nie są przypisane do drzewa
        $frames = static::select()
            ->fields(['frame_id'])
            ->source('::aloneNodes')
            ->equals('type', 'product-node')
            ->equals('tax_id', null)
            ->fetchAll();

        # usuń każdy samotny węzeł produktu
        foreach ($frames as $frame) {
            Frame::deleteByFrameId($frame['frame_id']);
        }
    }
}
