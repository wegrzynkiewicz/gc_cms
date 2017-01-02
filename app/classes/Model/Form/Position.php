<?php

namespace GC\Model\Form;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\PositionTrait;
use GC\Storage\Database;

class Position extends AbstractModel
{
    public static $table = '::form_pos';

    use ColumnTrait;
    use PrimaryTrait;
    use PositionTrait;

    protected static function updatePositionByFormId($form_id, array $positions)
    {
        static::deleteAllBy('form_id', $form_id);

        $pos = 1;
        foreach ($positions as $field) {

            static::insert([
                'form_id' => $form_id,
                'field_id' => $field['id'],
                'position' => $pos++,
            ]);
        }
    }
}
