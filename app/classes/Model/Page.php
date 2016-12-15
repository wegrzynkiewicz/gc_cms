<?php

namespace GCC\Model;

use GCC\Storage\AbstractModel;
use GCC\Storage\Utility\PrimaryTrait;
use GCC\Storage\Utility\ContainFrameTrait;
use GCC\Storage\Database;

class Page extends AbstractModel
{
    public static $table   = '::pages';
    public static $primary = 'page_id';

    use PrimaryTrait;
    use ContainFrameTrait;
}
