<?php

declare(strict_types=1);

namespace GC\Storage\Query;

class Update extends AbstractQuery
{
    protected $values = [];

    public function set(array $values): self
    {
        $this->values = $values;
        $this->addParams(array_values($this->values));

        return $this;
    }

    protected function buildSQL(): string
    {
        ob_start();

        echo "UPDATE {$this->source} SET ";

        $columns = [];
        foreach ($this->values as $column => $value) {
            $columns[] = "{$column} = ?";
        }

        echo implode(', ', $columns);

        if (count($this->conditions) > 0) {
            echo " WHERE ".implode(' AND ', array_map(function ($condition) {
                return "($condition)";
            }, $this->conditions));
        }

        if ($this->limit !== null) {
            echo " LIMIT {$this->limit}";
        }

        return ob_get_clean();
    }
}
