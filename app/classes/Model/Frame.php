<?php

class Frame extends Model
{
    public static $table   = '::frames';
    public static $primary = 'frame_id';

    use ColumnTrait;
    use PrimaryTrait;

    protected static function updateByFrameId($frame_id, array $data)
    {
        $data['modify_date'] = sqldate();

        return parent::updateByPrimaryId($frame_id, $data);
    }

    protected static function insert(array $data)
    {
        $data['creation_date'] = sqldate();
        $data['modify_date'] = sqldate();
        $data['settings'] = json_encode([]);

        return parent::insert($data);
    }
}