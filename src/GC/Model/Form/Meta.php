<?php

declare(strict_types=1);

namespace GC\Model\Form;

use GC\Storage\AbstractModel;

class Meta extends AbstractModel
{
    public static $table   = '::form_field_meta';
    public static $meta    = 'field_id';
}
