<?php

namespace GC\Storage\Utility;

use GC\Assert;
use GC\Data;

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
    public static function fetchByPrimaryId($primary_id)
    {
        return static::select(static::class)
            ->equals(static::$primary, $primary_id)
            ->limit(1)
            ->fetch();
    }

    /**
     * Aktualizuje dane $data rekordu o zadanym kluczu głownym
     */
    public static function updateByPrimaryId($primary_id, array $data = [])
    {
        static::update(static::class)
            ->set($data)
            ->equals(static::$primary, $primary_id)
            ->limit(1)
            ->execute();
    }

    /**
     * Usuwa rekord o zadanym kluczu głownym
     */
    public static function deleteByPrimaryId($primary_id)
    {
        return static::delete(static::class)
            ->equals(static::$primary, $primary_id)
            ->limit(1)
            ->execute();
    }
}
