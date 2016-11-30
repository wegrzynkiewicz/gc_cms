<?php

/**
 * Zbior funkcji pomagających operować na kluczu głownym tabeli
 * Dla prawidłowego działania wymaga w klasie pochodnej:
 * public static $table = "";
 * public static $primary = "";
 */
trait PrimaryTrait
{
    /**
     * Pobiera rekord o zadanym kluczu głownym
     */
    public static function selectByPrimaryId($primary_id)
    {
        $sql = self::sql("SELECT * FROM ::table WHERE ::primary = ? LIMIT 1");

        return Database::fetchSingle($sql, [intval($primary_id)]);
    }

    /**
     * Pobiera wszystkie rekordy z tabeli.
     * Zwraca tablice gdzie kluczem jest klucz glowny tabeli.
     */
    public static function selectAllWithPrimaryKey()
    {
        $sql = self::sql("SELECT * FROM ::table");
        $rows = Database::fetchAllWithKey($sql, [], static::$primary);

        return $rows;
    }

    /**
     * Pobiera wszystkie rekordy o $column rownym $value.
     * Zwraca tablice gdzie kluczem jest klucz glowny tabeli.
     */
    public static function selectAllWithPrimaryKeyBy($column, $value)
    {
        $sql = self::sql("SELECT * FROM ::table WHERE {$column} = ?");
        $rows = Database::fetchAllWithKey($sql, [$value], static::$primary);

        return $rows;
    }

    /**
     * Pobiera rekordy jako tablice ::primary => $column
     */
    public static function selectAllAsOptionsWithPrimaryKey($column)
    {
        $sql = self::sql("SELECT * FROM ::table");
        $permissions = Database::fetchAsOptionsWithPrimaryId($sql, [], static::$primary, $column);

        return $permissions;
    }

    /**
     * Aktualizuje dane $data rekordu o zadanym kluczu głownym
     */
    protected static function updateByPrimaryId($primary_id, array $data)
    {
        if (empty($data)) {
            return 0;
        }
        
        $columns = static::buildUpdateSyntax($data);
        $data[] = intval($primary_id);

        $sql = self::sql("UPDATE ::table SET {$columns} WHERE ::primary = ? LIMIT 1");
        $affectedRows = Database::execute($sql, array_values($data));

        return $affectedRows;
    }

    /**
     * Usuwa rekord o zadanym kluczu głownym
     */
    protected static function deleteByPrimaryId($primary_id)
    {
        $sql = self::sql("DELETE FROM ::table WHERE ::primary = ? LIMIT 1");
        $affectedRows = Database::execute($sql, [intval($primary_id)]);

        return $affectedRows;
    }
}
