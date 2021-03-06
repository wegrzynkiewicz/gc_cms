<?php

declare(strict_types=1);

namespace GC\Model;

use GC\Model\Module;
use GC\Validation\Validate;
use GC\Storage\AbstractNode;

class Frame extends AbstractNode
{
    public static $table = '::frames';
    public static $primary = 'frame_id';
    public static $nodeIndex = 'frame_id';
    public static $tree = '::frames LEFT JOIN ::frame_tree USING(frame_id)';

    public function getTitle(): string
    {
        if ($this->title) {
            return $this->title;
        }

        return $this->name;
    }

    /**
     * Zwraca wolny slug, lub pusty jeżeli jego brak
     */
    public static function proposeSlug($name, $lang, int $frame_id = 0): string
    {
        $proposedSlug = normalizeSlug($name);

        if ($lang !== $GLOBALS['config']['lang']['main']) {
            $proposedSlug = "/{$lang}{$proposedSlug}";
        }

        if (Validate::slug($proposedSlug, $frame_id)) {
            return $proposedSlug;
        }

        $number = 1;
        while (true) {
            $slug = $proposedSlug.'-'.intval($number);
            if (Validate::slug($slug, $frame_id)) {
                return $slug;
            }
            $number++;
        }

        return '';
    }

    /**
     * Usuwa rusztowanie, jego moduły i węzły jeżeli rusztowanie jest taksonomią
     */
    public static function deleteByFrameId(int $frame_id): void
    {
        // pobierz wszystkie węzły tej taksonomii
        $nodes = static::select()
            ->fields('frame_id')
            ->source('::tree')
            ->equals('taxonomy_id', $frame_id)
            ->fetchByPrimaryKey();

        // usuń każdy węzeł tej taksonomii
        foreach ($nodes as $node_id => $node) {
            static::deleteByFrameId($node_id);
        }

        // usuń wszystkie moduły dla rusztowania o frame_id
        Module::deleteByFrameId($frame_id);

        // usuń rusztowanie o id głownym
        static::deleteByPrimaryId($frame_id);
    }
}
