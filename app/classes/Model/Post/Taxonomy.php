<?php

namespace GC\Model\Post;

use GC\Storage\AbstractModel;

class Taxonomy extends AbstractModel
{
    public static $table   = '::post_taxonomies';
    public static $primary = 'tax_id';
}
