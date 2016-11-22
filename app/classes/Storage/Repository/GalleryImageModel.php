<?php

class GalleryImageModel extends AbstractModel
{
    public static $table      = '::gallery_images';
    public static $primary    = 'image_id';
    public static $groupTable = '::gallery_positions';
    public static $groupName  = 'gallery_id';

    use GroupModelTrait;
}
