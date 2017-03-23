<?php

namespace GC\Model\Form;

use GC\Storage\AbstractModel;

class Form extends AbstractModel
{
    public static $table   = '::forms';
    public static $primary = 'form_id';
}
