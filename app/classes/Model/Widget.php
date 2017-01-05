<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Database;

class Widget extends AbstractModel
{
    public static $table   = '::widgets';
    public static $primary = 'widget_id';

    use ColumnTrait;
    use PrimaryTrait;
}
