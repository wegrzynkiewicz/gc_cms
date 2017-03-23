<?php

declare(strict_types=1);

namespace GC\Model;

use GC\Storage\AbstractModel;

class Widget extends AbstractModel
{
    public static $table   = '::widgets';
    public static $primary = 'widget_id';
}
