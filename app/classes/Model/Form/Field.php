<?php

namespace GC\Model\Form;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\JoinTrait;
use GC\Storage\Database;

class Field extends AbstractModel
{
    public static $table       = '::form_fields';
    public static $primary     = 'field_id';
    public static $joinTable   = '::form_pos';
    public static $joinForeign = 'form_id';

    use PrimaryTrait;
    use JoinTrait;

    protected static function insertWithFormId(array $data, $form_id)
    {
        $field_id = parent::insert($data);

        Position::insert([
            'form_id' => $form_id,
            'field_id' => $field_id,
            'position' => Position::selectMaxPositionBy('form_id', $form_id),
        ]);

        return $field_id;
    }
}
