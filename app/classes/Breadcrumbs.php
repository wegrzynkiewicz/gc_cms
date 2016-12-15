<?php

namespace GCC;

class Breadcrumbs
{
    protected $links = array();

    public function getLinks()
    {
        return $this->links;
    }

    public function push($url, $title, array $args = [], $icon = null)
    {
        array_push($this->links, $this->wrap($url, $title, $args, $icon));
    }

    public function unshift($url, $title, array $args = [], $icon = null)
    {
        array_unshift($this->links, $this->wrap($url, $title, $args, $icon));
    }

    protected function wrap($url, $title, array $args, $icon)
    {
        return array(
            'title' => trans($title, $args),
            'url' => url($url),
            'icon' => $icon,
        );
    }
}
