<?php

namespace GrafCenter\CMS\Model;

use GrafCenter\CMS\Storage\AbstractModel;
use GrafCenter\CMS\Storage\Utility\PrimaryTrait;
use GrafCenter\CMS\Storage\Utility\ContainFrameTrait;
use GrafCenter\CMS\Storage\Database;

class Page extends AbstractModel
{
    public static $table   = '::pages';
    public static $primary = 'page_id';

    use PrimaryTrait;
    use ContainFrameTrait;
}
