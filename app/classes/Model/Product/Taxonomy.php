<?php

namespace GC\Model\Product;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;

class Taxonomy extends AbstractModel
{
    public static $table   = '::product_taxonomies';
    public static $primary = 'tax_id';

    use PrimaryTrait;
}
