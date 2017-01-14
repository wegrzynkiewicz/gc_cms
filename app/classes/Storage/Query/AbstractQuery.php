<?php

namespace GC\Storage\Query;

use GC\Assert;
use GC\Data;

abstract class AbstractQuery
{
    protected $database;
    protected $modelClass;
    protected $source = "::table";
    protected $conditions = [];
    protected $sort = [];
    protected $limit = null;
    protected $params = [];

    public function __construct($modelClass)
    {
        $this->modelClass = $modelClass;
        $this->database = call_user_func([$this->modelClass, 'getDatabase']);
    }

    public function condition($sqlPart, $passedParams = [])
    {
        $this->conditions[] = $sqlPart;
        $this->addParams($passedParams);
    }

    public function clearLimit()
    {
        $this->limit = null;
    }

    public function clearSort()
    {
        $this->sort = [];
    }

    public function equals($column, $passedParam)
    {
        $this->condition("{$column} = ?", [$passedParam]);

        return $this;
    }

    public function execute()
    {
        return $this->database->execute($this->getSQL(), $this->params);
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

    public function source($sqlParts)
    {
        $this->source = $sqlParts;

        return $this;
    }

    public function getParameters()
    {
        return $this->$params;
    }

    public function limit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    public function pagination($page, $epp)
    {
        $page = intval($page > 0 ? $page : 1);
        $epp = intval($epp > 0 ? $epp : 1);

        $this->limit = sprintf('%s, %s', ($page-1)*$epp, $epp);

        return $this;
    }

    public function sort($column, $order)
    {
        Assert::column($column);

        $order = strtoupper($order);
        if (!in_array($order, ['ASC', 'DESC'])) {
            return $this;
        }

        $this->sort[] = "{$column} {$order}";

        return $this;
    }

    protected function addParams($passedParams)
    {
        if (!is_array($passedParams)) {
            $passedParams = [$passedParams];
        }

        $this->params = array_merge($this->params, $passedParams);
    }

    protected abstract function buildSQL();

    protected function getSQL()
    {
        return call_user_func([$this->modelClass, 'sql'], $this->buildSQL());
    }
}
