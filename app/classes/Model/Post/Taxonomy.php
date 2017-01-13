<?php

namespace GC\Model\Post;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;

class Taxonomy extends AbstractModel
{
    public static $table   = '::post_taxonomies';
    public static $primary = 'tax_id';

    use PrimaryTrait;
}
