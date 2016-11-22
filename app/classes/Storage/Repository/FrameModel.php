<?php

class FrameModel extends AbstractModel
{
    public static $table   = '::frames';
    public static $primary = 'frame_id';

    public static function update($frame_id, array $data)
    {
        $data['modify_date'] = sqldate();

        return parent::update($frame_id, $data);
    }

    public static function insert(array $data)
    {
        $data['creation_date'] = sqldate();
        $data['modify_date'] = sqldate();
        $data['settings'] = json_encode([]);

        return parent::insert($data);
    }
}
