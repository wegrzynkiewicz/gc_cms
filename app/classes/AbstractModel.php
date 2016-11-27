<?php

abstract class AbstractModel
{
    public static function __callStatic($methodName, array $arguments)
    {
        if (!method_exists(get_called_class(), $methodName)) {
            throw new BadMethodCallException(sprintf(
                "Method named %s does not exists", $methodName
            ));
        }

        if (Database::$pdo->inTransaction()) {
            return call_user_func_array(['static', $methodName], $arguments);
        }

        Database::$pdo->beginTransaction();

        try {
            $result = call_user_func_array(['static', $methodName], $arguments);
            Database::$pdo->commit();
        } catch (Exception $exception) {
            Database::$pdo->rollBack();
            throw $exception;
        }

        return $result;
    }

    protected static function sql($pseudoQuery)
    {
        return preg_replace_callback('/(::(\w+))/', function ($matches) {
            $property = $matches[2];
            if ($property === 'lang') {
                return sprintf("lang = '%s'", getConfig()['lang']['editor']);
            }
            if (isset(static::$$property)) {
                return static::$$property;
            }

            return $matches[1];
        }, $pseudoQuery);
    }

    public static function selectAll()
    {
        $sql = self::sql("SELECT * FROM ::table");

        return Database::fetchAllWithPrimaryId($sql, [], static::$primary);
    }

    public static function selectBy($fieldLabel, $value)
    {
        $sql = self::sql("SELECT * FROM ::table WHERE {$fieldLabel} = ?");

        return Database::fetchAllWithPrimaryId($sql, [$value], static::$primary);
    }

    public static function selectSingleBy($fieldLabel, $value)
    {
        $sql = self::sql("SELECT * FROM ::table WHERE {$fieldLabel} = ? LIMIT 1");

        return Database::fetchSingle($sql, [$value]);
    }

    public static function selectByPrimaryId($id)
    {
        $sql = self::sql("SELECT * FROM ::table WHERE ::primary = ? LIMIT 1");

        return Database::fetchSingle($sql, [$id]);
    }

    public static function selectMaxPositionParent($parent_id, $parent)
    {
        $sql = self::sql("SELECT MAX(position) AS maximum FROM ::table WHERE {$parent} = ? LIMIT 1 ");
        $maxOrder =  Database::fetchSingle($sql, [$parent_id]);

        return intval($maxOrder['maximum']) + 1;
    }

    public static function selectAllAsOptions()
    {
        $rows = self::selectAll();

        $options = [];
        foreach($rows as $row) {
            $options[$row[static::$primary]] = $row['name'];
        }

        return $options;
    }

    protected static function deleteByPrimaryId($id)
    {
        $sql = self::sql("DELETE FROM ::table WHERE ::primary = ? LIMIT 1");

        return Database::execute($sql, [$id]);
    }

    protected static function deleteBy($field, $value)
    {
        $sql = self::sql("DELETE FROM ::table WHERE {$field} = ?");

        return Database::execute($sql, [$value]);
    }

    protected static function update($id, array $data)
    {
        $columns = Database::getUpdateSyntax($data);
        $data[] = $id;

        $sql = self::sql("UPDATE ::table SET {$columns} WHERE ::primary = ? LIMIT 1");

        return Database::execute($sql, array_values($data));
    }

    protected static function insert(array $data)
    {
        return Database::insertDataToTable(static::$table, $data);
    }
}
