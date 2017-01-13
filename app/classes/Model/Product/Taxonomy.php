<?php

namespace GC\Model\Product;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Container;

class Taxonomy extends AbstractModel
{
    public static $table   = '::product_taxonomies';
    public static $primary = 'tax_id';

    use ColumnTrait;
    use PrimaryTrait;
}
