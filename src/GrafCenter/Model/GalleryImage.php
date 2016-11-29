<?php

class GalleryImage extends Model
{
    public static $table   = '::gallery_images';
    public static $primary = 'image_id';

    use ColumnTrait;
    use PrimaryTrait;

    public static function selectAllByGalleryId($gallery_id)
    {
        $sql = self::sql("SELECT * FROM ::table LEFT JOIN ::gallery_pos AS p USING (::primary) WHERE p.gallery_id = ? ORDER BY position ASC");
        $rows = Database::fetchAllWithKey($sql, [intval($gallery_id)], static::$primary);

        return $rows;
    }

    protected static function deleteAllByGalleryId($gallery_id)
    {
        $sql = self::sql("DELETE t FROM ::table AS t LEFT JOIN ::gallery_pos AS p USING (::primary) WHERE p.gallery_id = ?");
        $affectedRows = Database::execute($sql, [intval($gallery_id)]);

        return $affectedRows;
    }

    protected static function insert(array $data, $gallery_id)
    {
        $image_id = parent::insert($data);

        GalleryPosition::insert([
            'gallery_id' => $gallery_id,
            'image_id' => $image_id,
            'position' => GalleryPosition::selectMaxPositionBy('gallery_id', $gallery_id),
        ]);

        return $image_id;
    }
}
