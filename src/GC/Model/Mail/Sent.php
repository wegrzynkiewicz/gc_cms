<?php

declare(strict_types=1);

namespace GC\Model\Mail;

use GC\Storage\AbstractModel;

class Sent extends AbstractModel
{
    public static $table   = '::mail_sent';
    public static $primary = 'mail_id';

    public static function insert(array $data)
    {
        $data['sent_datetime'] = sqldate();

        return parent::insert($data);
    }
}
