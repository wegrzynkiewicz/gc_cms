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

    public function getBeforeLastUrl()
    {
        $beforeLast = count($this->links)-2;
        if (isset($this->links[$beforeLast])) {
            return $this->links[$beforeLast]['url'];
        }

        return '/';
    }

    public function getLastUrl()
    {
        $last = count($this->links)-1;
        if (isset($this->links[$last])) {
            return $this->links[$last]['url'];
        }

        return '/';
    }
}
