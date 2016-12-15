<?php

namespace GCC\Model;

use GCC\Storage\AbstractModel;
use GCC\Storage\Utility\PrimaryTrait;
use GCC\Storage\Database;

class FrameModule extends AbstractModel
{
    public static $table   = '::frame_modules';
    public static $primary = 'module_id';

    use PrimaryTrait;

    public static function selectAllByFrameId($frame_id)
    {
        $sql = self::sql("SELECT * FROM ::table LEFT JOIN ::frame_pos AS p USING (::primary) WHERE p.frame_id = ?");
        $rows = Database::fetchAllWithKey($sql, [$frame_id], static::$primary);

        return $rows;
    }

    /**
     * Usuń wszystkie moduły dla rusztowania o id podstawowego
     */
    protected static function deleteAllByFrameId($frame_id)
    {
        $sql = self::sql("DELETE m FROM ::table AS m LEFT JOIN ::frame_pos AS p USING (::primary) WHERE frame_id = ?");
        $affectedRows = Database::execute($sql, [intval($frame_id)]);

        return $affectedRows;
    }

    protected static function insert(array $data, $frame_id)
    {
        $module_id = parent::insert($data);

        FramePosition::insert([
            'frame_id' => $frame_id,
            'module_id' => $module_id,
            'grid' => '0:10:12:1',
        ]);

        return $module_id;
    }
}
