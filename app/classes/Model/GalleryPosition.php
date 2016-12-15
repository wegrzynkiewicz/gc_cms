<?php

class GalleryPosition extends Model
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
