<?php

namespace GC\Model\Product;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\ContainFrameTrait;
use GC\Data;

class Product extends AbstractModel
{
    public static $table   = '::products';
    public static $frame   = '::products JOIN ::frames USING (frame_id)';
    public static $primary = 'product_id';

    use PrimaryTrait;
    use ContainFrameTrait;
}
