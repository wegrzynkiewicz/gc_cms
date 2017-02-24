<?php

namespace GC\Model\Post;

use GC\Model\Frame;
use GC\Storage\AbstractNode;

class Tree extends AbstractNode
{
    public static $table      = '::post_tree';
    public static $node       = 'frame_id';
    public static $nodes      = '::post_tree LEFT JOIN ::frames USING(frame_id)';
    public static $aloneNodes = '::post_tree RIGHT JOIN ::frames USING(frame_id)';

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
            ->equals('type', 'post-node')
            ->equals('tax_id', null)
            ->fetchAll();

        # usuń każdy samotny węzeł produktu
        foreach ($frames as $frame) {
            Frame::deleteByFrameId($frame['frame_id']);
        }
    }
}
