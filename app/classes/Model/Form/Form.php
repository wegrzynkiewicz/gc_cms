<?php

namespace GC\Model\Form;

use GC\Assert;
use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Container;

class Form extends AbstractModel
{
    public static $table   = '::forms';
    public static $primary = 'form_id';

    use ColumnTrait;
    use PrimaryTrait;
}
