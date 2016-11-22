<?php

trait GroupModelTrait
{
    public static function selectMergeByPrimaryId($primary_id)
    {
        $sql = self::sql("SELECT * FROM ::groupTable WHERE ::primary = ? LIMIT 1");
        $row = Database::fetchSingle($sql, [$primary_id]);

        return $row;
    }

    public static function selectAllByGroupId($group_id)
    {
        $sql = self::sql("SELECT * FROM ::table LEFT JOIN ::groupTable AS p USING (::primary) WHERE p.::groupName = ? ORDER BY position ASC");
        $rows = Database::fetchAllWithPrimaryId($sql, [$group_id], static::$primary);

        return $rows;
    }

    public static function selectMaxPositionByGroupId($group_id)
    {
        $sql = self::sql("SELECT MAX(position) AS maximum FROM ::groupTable WHERE ::groupName = ? LIMIT 1 ");
        $maxOrder =  Database::fetchSingle($sql, [$group_id]);

        return $maxOrder['maximum'] + 1;
    }

    protected static function deleteAndUpdatePositionByPrimaryId($primary_id)
    {
        $row = static::selectMergeByPrimaryId($primary_id);

        parent::deleteByPrimaryId($primary_id);

        $sql = self::sql("UPDATE ::groupTable SET position = position - 1 WHERE ::groupName = ? AND position > ?");
        Database::execute($sql, [intval($row[static::$groupName]), intval($row['position'])]);
    }

    protected static function moveUp($primary_id)
    {
        $record = static::selectMergeByPrimaryId($primary_id);

        $sql = self::sql("UPDATE ::groupTable SET position = position + 1 WHERE ::groupName = ? AND position = ?");
        Database::execute($sql, [intval($record[static::$groupName]), intval($record['position']-1)]);

        $sql = self::sql("UPDATE ::groupTable SET position = position - 1 WHERE ::primary = ?");
        Database::execute($sql, [$primary_id]);
    }

    protected static function moveDown($primary_id)
    {
        $record = static::selectMergeByPrimaryId($primary_id);

        $sql = self::sql("UPDATE ::groupTable SET position = position - 1 WHERE ::groupName = ? AND position = ?");
        Database::execute($sql, [intval($record[static::$groupName]), intval($record['position']+1)]);

        $sql = self::sql("UPDATE ::groupTable SET position = position + 1 WHERE ::primary = ?");
        Database::execute($sql, [$primary_id]);
    }

    protected static function updatePositionsByGroupId($group_id, array $positions)
    {
        $sql = self::sql("DELETE FROM ::groupTable WHERE ::groupName = ?");
        Database::execute($sql, [$group_id]);

        $pos = 1;
        foreach ($positions as $primary_id) {
            Database::insertDataToTable(static::$groupTable, [
                static::$groupName => $group_id,
                static::$primary => intval($primary_id),
                'position' => $pos++,
            ]);
        }
    }

    protected static function insertToGroupId($group_id, array $data)
    {
        $primary_id = parent::insert($data);

        Database::insertDataToTable(static::$groupTable, [
            static::$groupName => $group_id,
            static::$primary => $primary_id,
            'position' => static::selectMaxPositionByGroupId($group_id),
        ]);

        return $primary_id;
    }
}