<?php

namespace GC\Model;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Criteria;
use GC\Storage\Database;

class FormSent extends AbstractModel
{
    public static $table   = '::form_sent';
    public static $primary = 'sent_id';

    use ColumnTrait;
    use PrimaryTrait;

    /**
     * Pobiera wszystkie wiadomości dla zadanego $form_id sortowane po dacie
     */
    public static function selectByCriteria(Criteria $criteria)
    {
        $sql = self::sql("SELECT sent_id, name, status, sent_date FROM ::table {$criteria}");
        $rows = Database::fetchAll($sql, $criteria->getValues());

        return $rows;
    }

    /**
     * Pobiera wszystkie wiadomości dla zadanego $form_id sortowane po dacie
     */
    public static function countByCriteria(Criteria $criteria)
    {
        $criteria->clearLimit();
        $criteria->clearSort();
        $sql = self::sql("SELECT COUNT(*) AS count FROM ::table {$criteria}");
        $data = Database::fetchSingle($sql, $criteria->getValues());

        return intval($data['count']);
    }

    /**
     * Pobiera ilość wiadomości dla $form_id
     */
    public static function countByFormId($form_id)
    {
        $sql = self::sql("SELECT COUNT(*) AS count FROM ::table WHERE form_id = ? LIMIT 1");
        $data = Database::fetchSingle($sql, [$form_id]);

        return intval($data['count']);
    }

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
            'sent_date' => sqldate(),
            'name' => substr(reset($data), 0, 120),
            'data' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'localization' => json_encode($localization, JSON_UNESCAPED_UNICODE),
        ];

        return parent::insert($record);
    }
}
