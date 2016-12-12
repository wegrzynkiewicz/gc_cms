<?php

class MailSent extends Model
{
    public static $table   = '::mail_sent';
    public static $primary = 'mail_id';

    use ColumnTrait;
    use PrimaryTrait;

    protected static function insert(array $data)
    {
        $data['sent_date'] = sqldate();

        return parent::insert($data);
    }
}
