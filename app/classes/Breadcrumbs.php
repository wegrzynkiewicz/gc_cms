<?php

class Breadcrumbs
{
    protected $links = array();

    public function getLinks()
    {
        return $this->links;
    }

    public function push($url, $title, array $args = [])
    {
        array_push($this->links, $this->wrap($url, $title, $args));
    }

    public function unshift($url, $title, array $args = [])
    {
        array_unshift($this->links, $this->wrap($url, $title, $args));
    }

    protected function wrap($url, $title, array $args)
    {
        return array(
            'title' => vsprintf(trans($title), $args),
            'url' => url($url),
        );
    }
}
