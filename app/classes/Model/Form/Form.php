<?php

namespace GC\Model\Form;

use GC\Assert;
use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Data;

class Form extends AbstractModel
{
    public static $table   = '::forms';
    public static $primary = 'form_id';

    use PrimaryTrait;
}
