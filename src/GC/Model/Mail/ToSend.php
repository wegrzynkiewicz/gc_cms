<?php

declare(strict_types=1);

namespace GC\Model\Mail;

use GC\Storage\AbstractModel;

class ToSend extends AbstractModel
{
    public static $table = '::mail_to_send';
    public static $primary = 'mail_id';

    public static function insert(array $data): int
    {
        $data['push_datetime'] = sqldate();

        return parent::insert($data);
    }
}
