<?php

class Gallery extends Model
{
    public static $table   = '::galleries';
    public static $primary = 'gallery_id';

    use ColumnTrait;
    use PrimaryTrait;
}
