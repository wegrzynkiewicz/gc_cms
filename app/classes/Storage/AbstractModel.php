<?php

namespace GC\Storage;

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
    public static function __callStatic($methodName, array $arguments)
    {
        # jezeli metoda statyczne o nazwie $methodName nieistnieje
        $calledClass = get_called_class();
        if (!method_exists($calledClass, $methodName)) {
            throw new BadMethodCallException(sprintf(
                "Method named %s does not exists in %s", $methodName, $calledClass
            ));
        }

        # jezeli juz jesteśmy w transakcji wtedy wywołaj metodę chronioną
        if (Database::$pdo->inTransaction()) {
            return call_user_func_array(['static', $methodName], $arguments);
        }

        # rozpocznij transakcję
        Database::$pdo->beginTransaction();

        try {
            # wywołaj metodę chronioną i zapisz zmiany w bazie
            $result = call_user_func_array(['static', $methodName], $arguments);
            Database::$pdo->commit();
        } catch (Exception $exception) {
            # w przypadku błędu przywroc zmiany
            Database::$pdo->rollBack();
            throw $exception;
        }

        # zwroc wynik zapytania
        return $result;
    }

    /**
     * Wyszukuje w zapytaniu fraz :: i podstawia odpowiednie wartości statycznych pol klas.
     */
    protected static function sql($pseudoQuery)
    {
        return preg_replace_callback('/(::(\w+))/', function ($matches) {
            $property = $matches[2];
            if (isset(static::$$property)) {
                return static::$$property;
            }
            return $matches[1];
        }, $pseudoQuery);
    }

    protected static function buildUpdateSyntax(array $data)
    {
        $columns = [];
        foreach ($data as $column => $value) {
            Database::assertColumn($column);
            $columns[] = "`{$column}` = ?";
        }

        $mergedColumns = implode(', ', $columns);

        return $mergedColumns;
    }

    /**
     * Buduje i wykonuje zapytanie INSERT dla zadanych danych
     */
    protected static function insert(array $data)
    {
        $filled = array_fill(0, count($data), '?');
        $values = implode(', ', $filled);

        $columns = array_keys($data);
        array_map(function($column){
            Database::assertColumn($column);
        }, $columns);
        $columns = implode(', ', $columns);

        $sql = self::sql("INSERT INTO ::table ({$columns}) VALUES ({$values})");
        $row_id = Database::insert($sql, array_values($data));

        return $row_id;
    }    
}
