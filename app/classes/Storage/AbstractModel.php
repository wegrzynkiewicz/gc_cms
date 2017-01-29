<?php

namespace GC\Storage;

use GC\Assert;
use GC\Data;
use GC\Storage\Query;

/**
 * Reprezentuje zarowno tablice jak i pojedynczy rekord z bazy danych
 * Wszystkie statyczne metody odnoszą sie do operacji na tablicy, natomiast
 * niestatyczne metody są własnością konkretnego obiektu, czyli wiersza z bazy
 */
abstract class AbstractModel extends AbstractEntity
{
    /**
     * Wyszukuje w zapytaniu fraz :: i podstawia odpowiednie wartości statycznych pol klas.
     */
    public static function sql($pseudoQuery)
    {
        return preg_replace_callback('/(::(\w+))/', function ($matches) {
            $property = $matches[2];
            if (isset(static::$$property)) {
                return static::$$property;
            }
            return $matches[1];
        }, $pseudoQuery);
    }

    public static function delete()
    {
        return new Query\Delete(static::class);
    }

    /**
     * Buduje i wykonuje zapytanie INSERT dla zadanych danych
     */
    public static function insert(array $data)
    {
        $filled = array_fill(0, count($data), '?');
        $values = implode(', ', $filled);
        $columns = implode(', ', array_keys($data));

        $sql = static::sql("INSERT INTO ::table ({$columns}) VALUES ({$values})");
        $row_id = Database::getInstance()->insert($sql, array_values($data));

        return $row_id;
    }

    /**
     * Buduje i wykonuje zapytanie REPLACE dla zadanych danych
     */
    public static function replace(array $data)
    {
        $filled = array_fill(0, count($data), '?');
        $values = implode(', ', $filled);
        $columns = implode(', ', array_keys($data));

        $sql = static::sql("REPLACE INTO ::table ({$columns}) VALUES ({$values})");

        Database::getInstance()->execute($sql, array_values($data));
    }

    public static function select()
    {
        return new Query\Select(static::class);
    }

    public static function update()
    {
        return new Query\Update(static::class);
    }
}
