<?php

declare(strict_types=1);

namespace GC\Storage;

use GC\Assert;
use GC\Storage\Query\Select;
use GC\Storage\Query\Update;
use GC\Storage\Query\Delete;

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
    public static function sql(string $pseudoQuery): string
    {
        return preg_replace_callback('/(::(\w+))/', function ($matches) {
            $property = $matches[2];
            if (isset(static::$$property)) {
                return static::$$property;
            }
            return $matches[1];
        }, $pseudoQuery);
    }

    public static function delete(): Delete
    {
        return new Delete(static::class);
    }

    /**
     * Buduje i wykonuje zapytanie INSERT dla zadanych danych
     */
    public static function insert(array $data): int
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
    public static function replace(array $data): int
    {
        $filled = array_fill(0, count($data), '?');
        $values = implode(', ', $filled);
        $columns = implode(', ', array_keys($data));

        $sql = static::sql("REPLACE INTO ::table ({$columns}) VALUES ({$values})");

        return Database::getInstance()->execute($sql, array_values($data));
    }

    public static function select(): Select
    {
        return new Select(static::class);
    }

    public static function update(): Update
    {
        return new Update(static::class);
    }

    public static function execute(string $sql, array $params = []): int
    {
        $sql = static::sql($sql);

        return Database::getInstance()->execute($sql, $params);
    }

    /**
     * Pobiera rekord o zadanym kluczu głownym
     */
    public static function fetchByPrimaryId($primary_id): array
    {
        return static::select(static::class)
            ->equals(static::$primary, $primary_id)
            ->limit(1)
            ->fetch();
    }

    /**
     * Aktualizuje dane $data rekordu o zadanym kluczu głownym
     */
    public static function updateByPrimaryId(int $primary_id, array $data = []): int
    {
        return static::update(static::class)
            ->set($data)
            ->equals(static::$primary, $primary_id)
            ->limit(1)
            ->execute();
    }

    /**
     * Usuwa rekord o zadanym kluczu głownym
     */
    public static function deleteByPrimaryId(int $primary_id): int
    {
        return static::delete(static::class)
            ->equals(static::$primary, $primary_id)
            ->limit(1)
            ->execute();
    }

    public static function fetchMeta(int $meta_id): array
    {
        return static::select(static::class)
            ->fields(['name', 'value'])
            ->equals(static::$meta, $meta_id)
            ->fetchByMap('name', 'value');
    }

    public static function updateMeta(int $meta_id, array $data): void
    {
        foreach ($data as $name => $value) {
            static::replace([
                static::$meta => $meta_id,
                'name' => $name,
                'value' => $value,
            ]);
        }
    }

    public static function deleteMeta(int $meta_id, array $data): void
    {
        foreach ($data as $name) {
            static::delete()
                ->equals(static::$meta, $meta_id)
                ->equals('name', $name)
                ->execute();
        }
    }
}
