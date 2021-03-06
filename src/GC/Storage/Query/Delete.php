<?php

declare(strict_types=1);

namespace GC\Storage\Query;

class Delete extends AbstractQuery
{
    protected $target = '';

    public function target(string $target): self
    {
        $this->target = $target;

        return $this;
    }

    protected function buildSQL(): string
    {
        ob_start();

        echo trim("DELETE ".$this->target);
        echo " FROM ".$this->source;

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
