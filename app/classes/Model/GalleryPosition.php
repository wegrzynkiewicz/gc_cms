<?php

namespace GCC\Model;

use GCC\Storage\AbstractModel;
use GCC\Storage\Utility\ColumnTrait;
use GCC\Storage\Utility\PrimaryTrait;
use GCC\Storage\Database;

class GalleryPosition extends AbstractModel
{
    public static $table = '::gallery_pos';

    use ColumnTrait;
    use PositionTrait;

    protected static function updatePositionsByGalleryId($gallery_id, array $positions)
    {
        static::deleteAllBy('gallery_id', $gallery_id);

        $pos = 1;
        foreach ($positions as $image_id) {
            static::insert([
                'gallery_id' => $gallery_id,
                'image_id' => $image_id,
                'position' => $pos++,
            ]);
        }
    }
}
