<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\ContainFrameTrait;
use GC\Data;

class Page extends AbstractModel
{
    public static $table   = '::pages';
    public static $primary = 'page_id';

    use PrimaryTrait;
    use ContainFrameTrait;
}
