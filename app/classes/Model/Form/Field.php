<?php

namespace GC\Model\Form;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\JoinTrait;
use GC\Container;

class Field extends AbstractModel
{
    public static $table       = '::form_fields';
    public static $primary     = 'field_id';
    public static $joinTable   = '::form_pos';
    public static $joinForeign = 'form_id';

    use PrimaryTrait;
    use JoinTrait;
}
