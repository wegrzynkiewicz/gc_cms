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

        return Database::fetchAllWithPrimaryId($sql, [], static::$primary);
    }

    /**
     * Pobiera wszystkie rekordy o $column rownym $value.
     * Zwraca tablice gdzie kluczem jest klucz glowny tabeli.
     */
    public static function selectAllWithPrimaryKeyBy($column, $value)
    {
        $sql = self::sql("SELECT * FROM ::table WHERE {$column} = ?");

        return Database::fetchAllWithPrimaryId($sql, [$value], static::$primary);
    }

    /**
     * Aktualizuje dane $data rekordu o zadanym kluczu głownym
     */
    protected static function updateByPrimaryId($primary_id, array $data)
    {
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

        return Database::execute($sql, [intval($primary_id)]);
    }
}
