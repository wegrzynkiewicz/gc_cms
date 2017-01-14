<?php

namespace GC\Model\Form;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\PositionTrait;
use GC\Data;

class Position extends AbstractModel
{
    public static $table = '::form_pos';

    use PrimaryTrait;
    use PositionTrait;
}
