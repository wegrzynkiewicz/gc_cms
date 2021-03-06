<?php

declare(strict_types=1);

namespace GC\Storage;

/**
 * Słuzy do wykonywania zapytań do bazy danych
 */
class Database
{
    private static $instance = null;

    public $pdo = null;
    public $prefix;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
            $this->pdo->beginTransaction();
        }
    }

    /**
     * Jeżeli nie wystąpił żaden błąd podczas transakcji wtedy commit
     */
    public function __destruct()
    {
        if (!$this->pdo->inTransaction()) {
            return;
        }

        if (error_get_last() === null) {
            $this->pdo->commit();
        } else {
            $this->pdo->rollBack();
        }
    }

    /**
     * Wykonuje zapytanie SQL i zwraca jeden wiersz z tego zapytania, przydatne dla pojedyńczych wywołań
     */
    public function fetch(string $sql, array $values = [])
    {
        return $this->wrapQuery($sql, $values, function ($statement) {
            return $statement->fetch(\PDO::FETCH_ASSOC);
        });
    }

    /**
     * Wykonuje zapytanie SQL i zwraca tablice wierszy z tego zapytania, przydatne dla wielu rekordow
     */
    public function fetchAll(string $sql, array $values = []): array
    {
        return $this->wrapQuery($sql, $values, function ($statement) {
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        });
    }

    /**
     * Wykonuje zapytanie SQL i zwraca tablice wierszy z tego zapytania gdzie
     * kluczem w tej tablicy jest columna przekazana jako $label,
     * przydatne dla wielu rekordow z dostępem swobodnym po kluczu w tablicy
     */
    public function fetchByKey(string $sql, array $values, string $label): array
    {
        $data = [];
        foreach ($this->fetchAll($sql, $values) as $row) {
            $data[$row[$label]] = $row;
        }

        return $data;
    }

    /**
     * Wykonuje zapytanie SQL i zwraca tablice wierszy z tego zapytania gdzie
     * kluczem w tej tablicy jest columna przekazana jako $label a wartością jest $column
     * przydatne dla wielu rekordow z dostępem swobodnym po kluczu w tablicy
     */
    public function fetchByMap(string $sql, array $values, string $label, string $column): array
    {
        $data = [];
        foreach ($this->fetchAll($sql, $values) as $row) {
            $data[$row[$label]] = $row[$column];
        }

        return $data;
    }

    /**
     * Wykonuje zapytanie SQL i zwraca ilość zmodyfikowanych rekordow
     */
    public function execute(string $sql, array $values = []): int
    {
        return $this->wrapQuery($sql, $values, function ($statement) {
            return $statement->rowCount();
        });
    }

    /**
     * Wykonuje zapytanie SQL i zwraca ID ostatniego wstawionego rekordu
     */
    public function insert(string $sql, array $values = []): int
    {
        $this->wrapQuery($sql, $values, function ($statement) {
        });

        return intval($this->pdo->lastInsertId());
    }

    /**
     * Przekazaną funkcje $callback otacza wewnątrz transakcji
     */
    public function transaction(callable $callback): void
    {
        if ($this->pdo->inTransaction()) {
            $callback();

            return;
        }

        try {
            $this->pdo->beginTransaction();
            $callback();
            $this->pdo->commit();
        } catch (PDOException $exception) {
            $this->pdo->rollBack();
            throw $exception;
        }
    }

    /**
     * Tworzy i pobiera tą samą instancję bazy danych dla aplikacji
     */
    public static function getInstance(): self
    {
        if (static::$instance === null) {
            $dbConfig = $GLOBALS['config']['database'];
            $pdo = new \PDO(
                $dbConfig['dns'],
                $dbConfig['username'],
                $dbConfig['password']
            );
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $database = new static($pdo);
            $database->prefix = $dbConfig['prefix'];

            logger('[DATABASE] Connected');
            static::$instance = $database;
        }

        return static::$instance;
    }

    /**
     * Wywołuje i loguje zapytania
     */
    private function wrapQuery(string $sql, array $values, callable $callback)
    {
        // dodaje prefix do każdego wyrazu zaczynającego się od ::
        $sql = preg_replace_callback('/::([a-z_]+)/', function ($matches) {
            return $this->prefix.$matches[1];
        }, $sql);

        logger(
            '[QUERY] '.($this->pdo->inTransaction() ? '(Transaction) :: ' : '').$sql,
            $values
        );

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($values);
            $result = $callback($statement);
        } catch (PDOException $exception) {
            $message = sprintf(
                "Query: %s; Params: %s",
                $sql, json_encode($values, JSON_PRETTY_PRINT)
            );
            throw new Exception($message, 0, $exception);
        }
        $statement->closeCursor();

        return $result;
    }
}
