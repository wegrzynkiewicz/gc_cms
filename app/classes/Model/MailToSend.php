<?php

class MailToSend extends Model
{
    public static $table   = '::mail_to_send';
    public static $primary = 'mail_id';

    use ColumnTrait;
    use PrimaryTrait;

    protected static function insert(array $data)
    {
        $data['push_date'] = sqldate();

        return parent::insert($data);
    }

    public static function selectLatest($limit)
    {
        $sql = self::sql("SELECT * FROM ::table LEFT JOIN ::frame_pos AS p USING (::primary) WHERE p.frame_id = ?");
        $rows = Database::fetchAllWithKey($sql, [$frame_id], static::$primary);

        return $rows;
    }
}