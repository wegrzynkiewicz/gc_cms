<?php

namespace GC\Model\Form;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Utility\CriteriaTrait;
use GC\Storage\Database;

class Sent extends AbstractModel
{
    public static $table   = '::form_sent';
    public static $primary = 'sent_id';

    use ColumnTrait;
    use PrimaryTrait;
    use CriteriaTrait;

    /**
     * Pobiera ilość nieprzeczytanych wiadomości dla każdego form_id
     */
    public static function selectSumStatusForFormId()
    {
        $sql = self::sql("SELECT form_id, SUM(status = 'unread') AS unread FROM ::table GROUP BY form_id");
        $rows = Database::fetchAllWithKey($sql, [], 'form_id');

        return $rows;
    }

    /**
     * Pobiera ilość wszystkich nieprzeczytanych wiadomości
     */
    public static function selectSumStatus()
    {
        $sql = self::sql("SELECT SUM(status = 'unread') AS unread FROM ::table LIMIT 1");
        $count = Database::fetchSingle($sql, []);

        return $count;
    }

    protected static function insertToForm($form_id, $data, $localization)
    {
        $record = [
            'form_id' => $form_id,
            'status' => 'unread',
            'sent_datetime' => sqldate(),
            'name' => substr(reset($data), 0, 120),
            'data' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'localization' => json_encode($localization, JSON_UNESCAPED_UNICODE),
        ];

        return parent::insert($record);
    }
}
