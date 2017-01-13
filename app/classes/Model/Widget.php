<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;

class Widget extends AbstractModel
{
    public static $table   = '::widgets';
    public static $primary = 'widget_id';

    use PrimaryTrait;
}
