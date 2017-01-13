<?php

namespace GC\Model\Product;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\ContainFrameTrait;
use GC\Container;

class Product extends AbstractModel
{
    public static $table   = '::products';
    public static $primary = 'product_id';

    use PrimaryTrait;
    use ContainFrameTrait;
}
