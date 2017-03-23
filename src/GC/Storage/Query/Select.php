<?php

declare(strict_types=1);

namespace GC\Storage\Query;

use GC\Assert;
use GC\Storage\Database;

class Select extends AbstractQuery
{
    protected $extract = '*';
    protected $groupBy = null;

    public function fields($extract): self
    {
        $this->extract = $extract;

        return $this;
    }

    public function group(string $group): self
    {
        $this->groupBy = $group;

        return $this;
    }

    public function fetch()
    {
        $this->limit(1);

        return Database::getInstance()->fetch($this->getSQL(), $this->params);
    }

    public function fetchAll(): array
    {
        return Database::getInstance()->fetchAll($this->getSQL(), $this->params);
    }

    public function fetchByKey($key): array
    {
        return Database::getInstance()->fetchByKey($this->getSQL(), $this->params, $key);
    }

    public function fetchByPrimaryKey()
    {
        return Database::getInstance()->fetchByKey(
            $this->getSQL(),
            $this->params,
            get_class_vars($this->modelClass)['primary']
        );
    }

    public function fetchByMap($keyLabel, $valueLabel): array
    {
        return Database::getInstance()->fetchByMap(
            $this->getSQL(),
            $this->params,
            $keyLabel,
            $valueLabel
        );
    }

    public function fetchObject()
    {
        $record = $this->fetch();
        if ($record) {
            $className = $this->modelClass;

            return new $className($record);
        }

        return null;
    }

    public function fetchTree()
    {
        $records = $this
            ->order('position', 'ASC')
            ->fetchAll();

        return call_user_func([$this->modelClass, 'createTree'], $records);
    }

    protected function buildSQL(): string
    {
        ob_start();

        echo "SELECT ";

        if (is_array($this->extract)) {
            $fields = [];
            foreach ($this->extract as $key => $column) {
                $fields[] = is_numeric($key) ? $column : "{$column} AS {$key}";
            }
            echo implode(', ', $fields);
        } else {
            echo $this->extract;
        }

        echo " FROM ".$this->source;

        if (count($this->conditions) > 0) {
            echo " WHERE ".implode(' AND ', array_map(function ($condition) {
                return "($condition)";
            }, $this->conditions));
        }

        if ($this->groupBy !== null) {
            echo " GROUP BY ".$this->groupBy;
        }

        if (count($this->sort) > 0) {
            echo " ORDER BY ";
            echo implode(", ", $this->sort);
        }

        if ($this->limit !== null) {
            echo " LIMIT {$this->limit}";
        }

        return ob_get_clean();
    }

    public function buildForDataTables(array $data): self
    {
        $columnNames = [];
        $searchableColumns = [];
        foreach ($data['columns'] as $number => $column) {
            $name = $column['name'];
            Assert::column($name);
            $columnNames[$number] = $name;

            if ($column['searchable']) {
                $searchableColumns[] = $column;
            }
        }

        $this->pagination(intval($data['start']), intval($data['length']));

        if (isset($data['order'])) {
            foreach ($data['order'] as $order) {
                $this->order($columnNames[$order['column']], $order['dir']);
            }
        }

        if (isset($data['search']) and $data['search']['value']) {
            $orCondition = '';
            $values = [];
            foreach ($searchableColumns as $column) {
                $orCondition[] = $column['name'].' LIKE ?';
                $values[] = '%'.$data['search']['value'].'%';
            }
            $condition = implode(' OR ', $orCondition);
            $this->condition($condition, $values);
        }

        return $this;
    }
}
