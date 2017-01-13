<?php

namespace GC\Model\Mail;

use GC\Storage\AbstractModel;
use GC\Storage\Utility\ColumnTrait;
use GC\Storage\Utility\PrimaryTrait;
use GC\Container;

class ToSend extends AbstractModel
{
    public static $table   = '::mail_to_send';
    public static $primary = 'mail_id';

    use ColumnTrait;
    use PrimaryTrait;

    public static function insert(array $data)
    {
        $data['push_datetime'] = sqldate();

        return parent::insert($data);
    }
}
