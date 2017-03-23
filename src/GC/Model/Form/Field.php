<?php

declare(strict_types=1);

namespace GC\Model\Form;

use GC\Storage\AbstractModel;

class Field extends AbstractModel
{
    public static $table   = '::form_fields';
    public static $primary = 'field_id';
    public static $fields  = '::form_fields LEFT JOIN ::form_pos USING(field_id)';
}
