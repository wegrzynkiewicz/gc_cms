<?php

class Nav extends Model
{
    public static $table   = '::navs';
    public static $primary = 'nav_id';

    use PrimaryTrait;
}
