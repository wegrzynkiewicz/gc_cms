<?php

namespace GC\Model\Mail;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Storage\Database;

class Sent extends AbstractModel
{
    public static $table   = '::mail_sent';
    public static $primary = 'mail_id';

    use ColumnTrait;
    use PrimaryTrait;

    protected static function insert(array $data)
    {
        $data['sent_datetime'] = sqldate();

        return parent::insert($data);
    }
}
