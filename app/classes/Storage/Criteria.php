<?php

namespace GC\Storage;

use GC\Assert;
use GC\Container;

class Criteria
{
    private $limit = null;
    private $sort = [];
    private $conditions = [];
    private $values = [];

    public function __toString()
    {
        return $this->buildCriteriaSQL();
    }

    public function getValues()
    {
        return $this->values;
    }

    public function clearLimit()
    {
        $this->limit = null;
    }

    public function clearSort()
    {
        $this->sort = [];
    }

    public function limit($limit)
    {
        $this->limit = $limit;
    }

    public function sort($column, $order)
    {
        Assert::column($column);

        $order = strtoupper($order);
        if (!in_array($order, ['ASC', 'DESC'])) {
            return $this;
        }

        $this->sort[] = "$column $order";
    }

    public function pagination($page, $epp)
    {
        $page = intval($page > 0 ? $page : 1);
        $epp = intval($epp > 0 ? $epp : 1);

        $this->limit = sprintf('%s, %s', ($page-1)*$epp, $epp);
    }

    public function unshiftCondition($partSQL, array $values)
    {
        array_unshift($this->conditions, $partSQL);
        foreach ($values as $value) {
            array_unshift($this->values, $value);
        }
    }

    public function pushCondition($partSQL, array $values)
    {
        array_push($this->conditions, $partSQL);
        foreach ($values as $value) {
            array_push($this->values, $value);
        }
    }

    public function buildCriteriaSQL()
    {
        ob_start();

        if (count($this->conditions) > 0) {
            echo " WHERE ".implode(' AND ', array_map(function($condition) {
                return "($condition)";
            }, $this->conditions));
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

    public static function createForDataTables(array $data)
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

        $criteria = new static();
        $criteria->pagination($data['start'], $data['length']);

        if (isset($data['order'])) {
            foreach ($data['order'] as $order) {
                $criteria->sort($columnNames[$order['column']], $order['dir']);
            }
        }

        if (isset($data['search']) and $data['search']['value']) {
            $orCondition = '';
            $values = [];
            foreach ($searchableColumns as $column) {
                $orCondition[] = sprintf('%s LIKE ?', $column['name']);
                $values[] = '%'.$data['search']['value'].'%';
            }
            $condition = implode(' OR ', $orCondition);
            $criteria->pushCondition($condition, $values);
        }

        return $criteria;
    }
}
