<?php

namespace GC\Model\Post;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Database;

class Taxonomy extends AbstractModel
{
    public static $table   = '::post_taxonomies';
    public static $primary = 'tax_id';

    use ColumnTrait;
    use PrimaryTrait;
}
