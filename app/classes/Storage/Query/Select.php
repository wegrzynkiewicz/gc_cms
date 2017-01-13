<?php

namespace GC\Storage\Query;

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
}
