<?php

declare(strict_types=1);

namespace GC\Model\Form;

use GC\Storage\AbstractModel;

class Sent extends AbstractModel
{
    public static $table = '::form_sent';
    public static $primary = 'sent_id';

    public static function insertToForm(int $form_id, array $data, array $localization): int
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
