<?php

namespace GC\Storage\Query;

class Delete extends AbstractQuery
{
    protected function buildSQL()
    {
        ob_start();

        echo "DELETE FROM ".$this->source;

        if (count($this->conditions) > 0) {
            echo " WHERE ".implode(' AND ', array_map(function($condition) {
                return "($condition)";
            }, $this->conditions));
        }

        if ($this->limit !== null) {
            echo " LIMIT {$this->limit}";
        }

        return ob_get_clean();
    }
}
