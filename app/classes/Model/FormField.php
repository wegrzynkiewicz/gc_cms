<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Database;

class FormField extends AbstractModel
{
    public static $table   = '::form_fields';
    public static $primary = 'field_id';

    use PrimaryTrait;

    /**
     * Pobiera wszystkie pola dla zadanego $form_id
     */
    public static function selectAllByFormId($form_id)
    {
        $sql = self::sql("SELECT * FROM ::table LEFT JOIN ::form_pos AS p USING (::primary) WHERE p.form_id = ? ORDER BY position ASC");
        $rows = Database::fetchAllWithKey($sql, [$form_id], static::$primary);

        return $rows;
    }

    /**
     * Usuń wszystkie pola dla formularza o $form_id
     */
    protected static function deleteAllByFormId($form_id)
    {
        $sql = self::sql("DELETE m FROM ::table AS m LEFT JOIN ::form_pos AS p USING (::primary) WHERE p.form_id = ?");
        $affectedRows = Database::execute($sql, [intval($form_id)]);

        return $affectedRows;
    }

    protected static function insertWithFormId(array $data, $form_id)
    {
        $field_id = parent::insert($data);

        FormPosition::insert([
            'form_id' => $form_id,
            'field_id' => $field_id,
            'position' => FormPosition::selectMaxPositionBy('form_id', $form_id),
        ]);

        return $field_id;
    }
}
