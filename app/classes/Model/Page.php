<?php

class Page extends Model
{
    public static $table   = '::pages';
    public static $primary = 'page_id';

    use PrimaryTrait;
    use ContainFrameTrait;
}
