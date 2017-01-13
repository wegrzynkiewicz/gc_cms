<?php

namespace GC\Storage;

use GC\Assert;
use GC\Storage\Query\Select;
use BadMethodCallException;
use RuntimeException;

/**
 * Reprezentuje zarowno tablice jak i pojedynczy rekord z bazy danych
 * Wszystkie statyczne metody odnoszą sie do operacji na tablicy, natomiast
 * niestatyczne metody są własnością konkretnego obiektu, czyli wiersza z bazy
 */
abstract class AbstractModel extends AbstractEntity
{
    /**
     * Jest uruchamiana w momencie wywołania metody chronionej lub nieistniejącej.
     * Gdy jest wywoływana wtedy sprawdza czy taka metoda istnieje i uruchamia
     * ją wewnętrz transakcji. Wystarczy wywołać chronioną metodę, aby zawrzeć
     * ją całą w transakcji.
     */
    public static function __callStatic($name, array $arguments)
    {
        # jezeli metoda statyczne o nazwie $name nieistnieje
        $calledClass = get_called_class();
        if (!method_exists($calledClass, $name)) {
            throw new BadMethodCallException(sprintf(
                "Method named %s does not exists in %s", $name, $calledClass
            ));
        }

        # jezeli juz jesteśmy w transakcji wtedy wywołaj metodę chronioną
        if (Container::get('database')->$pdo->inTransaction()) {
            return call_user_func_array(['static', $name], $arguments);
        }

        # rozpocznij transakcję
        Container::get('database')->$pdo->beginTransaction();

        try {
            # wywołaj metodę chronioną i zapisz zmiany w bazie
            $result = call_user_func_array(['static', $name], $arguments);
            Container::get('database')->$pdo->commit();
        } catch (Exception $exception) {
            # w przypadku błędu przywroc zmiany
            Container::get('database')->$pdo->rollBack();
            throw $exception;
        }

        # zwroc wynik zapytania
        return $result;
    }

    public static function delete()
    {
        return new Delete(static::class);
    }

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

    public static function select()
    {
        return new Select(static::class);
    }

    /**
     * Buduje i wykonuje zapytanie INSERT dla zadanych danych
     */
    public static function insert(array $data)
    {
        list($columns, $values) = self::buildInsertSyntax($data);
        $sql = self::sql("INSERT INTO ::table ({$columns}) VALUES ({$values})");
        $row_id = Container::get('database')->insert($sql, array_values($data));

        return $row_id;
    }

    /**
     * Buduje i wykonuje zapytanie REPLACE dla zadanych danych
     */
    public static function replace(array $data)
    {
        list($columns, $values) = self::buildInsertSyntax($data);
        $sql = self::sql("REPLACE INTO ::table ({$columns}) VALUES ({$values})");
        Container::get('database')->execute($sql, array_values($data));
    }

    protected static function buildInsertSyntax(array $data)
    {
        $filled = array_fill(0, count($data), '?');
        $values = implode(', ', $filled);

        $columns = array_keys($data);
        array_map(function($column){
            Assert::column($column);
        }, $columns);
        $columns = implode(', ', $columns);

        return [$columns, $values];
    }

    protected static function buildUpdateSyntax(array $data)
    {
        $columns = [];
        foreach ($data as $column => $value) {
            Assert::column($column);
            $columns[] = "`{$column}` = ?";
        }

        $mergedColumns = implode(', ', $columns);

        return $mergedColumns;
    }

    protected static function deleteAll()
    {
        $sql = self::sql("DELETE FROM ::table ");
        $affectedRows = Container::get('database')->execute($sql);

        return $affectedRows;
    }
}
