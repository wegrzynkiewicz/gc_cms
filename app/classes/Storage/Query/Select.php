<?php

namespace GC\Storage\Query;

use GC\Assert;

class Select extends AbstractQuery
{
    protected $extract = '*';
    protected $groupBy = null;

    public function fields($extract)
    {
        $this->extract = $extract;

        return $this;
    }

    public function groupBy($groupBy)
    {
        $this->groupBy = $groupBy;

        return $this;
    }

    public function fetch()
    {
        $this->limit(1);

        return $this->database->fetch($this->getSQL(), $this->params);
    }

    public function fetchAll()
    {
        return $this->database->fetchAll($this->getSQL(), $this->params);
    }

    public function fetchByKey($key)
    {
        return $this->database->fetchByKey($this->getSQL(), $this->params, $key);
    }

    public function fetchByPrimaryKey()
    {
        return $this->database->fetchByKey(
            $this->getSQL(),
            $this->params,
            get_class_vars($this->modelClass)['primary']
        );
    }

    public function fetchByMap($keyLabel, $valueLabel)
    {
        return $this->database->fetchByMap(
            $this->getSQL(),
            $this->params,
            $keyLabel,
            $valueLabel
        );
    }

    public function fetchTree()
    {
        $records = $this
            ->sort('position', 'ASC')
            ->fetchAll();

        return call_user_func([$this->modelClass, 'createTree'], $records);
    }

    protected function buildSQL()
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
            echo " WHERE ".implode(' AND ', array_map(function($condition) {
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

    public function buildForDataTables(array $data)
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

        $this->pagination($data['start'], $data['length']);

        if (isset($data['order'])) {
            foreach ($data['order'] as $order) {
                $this->sort($columnNames[$order['column']], $order['dir']);
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
