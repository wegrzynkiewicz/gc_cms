<?php

namespace GC\Model;

use GC\Storage\AbstractModel;

class Lang extends AbstractModel
{
    public static $table       = '::langs';
    public static $primary     = 'code';
}
