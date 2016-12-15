<?php

namespace GrafCenter\CMS\Model;

use GrafCenter\CMS\Storage\AbstractModel;
use GrafCenter\CMS\Storage\Utility\ColumnTrait;
use GrafCenter\CMS\Storage\Utility\PrimaryTrait;
use GrafCenter\CMS\Storage\Database;

class MailSent extends AbstractModel
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
