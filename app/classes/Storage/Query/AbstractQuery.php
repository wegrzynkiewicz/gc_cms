<?php

namespace GC\Storage\Query;

use GC\Assert;
use GC\Storage\Database;

abstract class AbstractQuery
{
    protected $modelClass;
    protected $source = "::table";
    protected $conditions = [];
    protected $sort = [];
    protected $limit = null;
    protected $params = [];

    public function __construct($modelClass)
    {
        $this->modelClass = $modelClass;
    }

    public function condition($sqlPart, $passedParams = [])
    {
        $this->conditions[] = $sqlPart;
        $this->addParams($passedParams);

        return $this;
    }

    public function clearLimit()
    {
        $this->limit = null;

        return $this;
    }

    public function clearSort()
    {
        $this->sort = [];

        return $this;
    }

    public function equals($column, $passedParam)
    {
        if ($passedParam === null) {
            $this->condition("{$column} IS NULL");
        } else {
            $this->condition("{$column} = ?", [$passedParam]);
        }

        return $this;
    }

    public function execute()
    {
        return Database::getInstance()->execute($this->getSQL(), $this->params);
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

    public function getSQL()
    {
        return call_user_func([$this->modelClass, 'sql'], $this->buildSQL());
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

    public function order($column, $order)
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

        return $this;
    }

    protected abstract function buildSQL();
}
