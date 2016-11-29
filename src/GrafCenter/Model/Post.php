<?php

class Post extends Model
{
    public static $table   = '::posts';
    public static $primary = 'post_id';

    use PrimaryTrait;
    use ContainFrameTrait;
}
