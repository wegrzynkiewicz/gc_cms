<?php

declare(strict_types=1);

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

    public function __construct(string $modelClass)
    {
        $this->modelClass = $modelClass;
    }

    public function condition(string $sqlPart, array $passedParams = []): self
    {
        $this->conditions[] = $sqlPart;
        $this->addParams($passedParams);

        return $this;
    }

    public function clearLimit(): self
    {
        $this->limit = null;

        return $this;
    }

    public function clearSort(): self
    {
        $this->sort = [];

        return $this;
    }

    public function equals(string $column, $passedParam): self
    {
        if ($passedParam === null) {
            $this->condition("{$column} IS NULL");
        } else {
            $this->condition("{$column} = ?", [$passedParam]);
        }

        return $this;
    }

    public function execute(): int
    {
        return Database::getInstance()->execute($this->getSQL(), $this->params);
    }

    public function source(string $sqlParts): self
    {
        $this->source = $sqlParts;

        return $this;
    }

    public function getParameters(): array
    {
        return $this->$params;
    }

    public function getSQL(): string
    {
        return call_user_func([$this->modelClass, 'sql'], $this->buildSQL());
    }

    public function limit($limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function pagination(int $page, int $epp): self
    {
        $page = intval($page > 0 ? $page : 1);
        $epp = intval($epp > 0 ? $epp : 1);

        $this->limit = sprintf('%s, %s', ($page-1)*$epp, $epp);

        return $this;
    }

    public function order(string $column, string $order): self
    {
        Assert::column($column);

        $order = strtoupper($order);
        if (!in_array($order, ['ASC', 'DESC'])) {
            return $this;
        }

        $this->sort[] = "{$column} {$order}";

        return $this;
    }

    protected function addParams(array $passedParams): self
    {
        $this->params = array_merge($this->params, $passedParams);

        return $this;
    }

    abstract protected function buildSQL(): string;
}
