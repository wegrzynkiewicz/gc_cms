<?php

namespace GC;

class Breadcrumbs
{
    protected $links = array();

    public function getLinks()
    {
        return $this->links;
    }

    public function push(array $data)
    {
        array_push($this->links, $data);
    }

    public function unshift(array $data)
    {
        array_unshift($this->links, $data);
    }

    public function getBeforeLast($index)
    {
        return getValueByKeys(
            $this->links,
            [count($this->links)-2, $index],
            '/'
        );
    }

    public function getLast($index)
    {
        return getValueByKeys(
            $this->links,
            [count($this->links)-1, $index],
            '/'
        );
    }
}
