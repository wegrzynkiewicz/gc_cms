<?php

namespace GC\Model\Product;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Database;

class Membership extends AbstractModel
{
    public static $table = '::product_membership';

    use ColumnTrait;
}
