<?php

namespace GC;

class Breadcrumbs
{
    protected $links = array();

    public function getLinks()
    {
        return $this->links;
    }

    public function push($url, $title, $icon = null)
    {
        array_push($this->links, $this->wrap($url, $title, $icon));
    }

    public function unshift($url, $title, $icon = null)
    {
        array_unshift($this->links, $this->wrap($url, $title, $icon));
    }

    public function getBeforeLastUrl()
    {
        $beforeLast = count($this->links)-2;
        if (isset($this->links[$beforeLast])) {

            return $this->links[$beforeLast]['url'];
        }

        return '';
    }

    public function getLastUrl()
    {
        $last = count($this->links)-1;
        if (isset($this->links[$last])) {
            return $this->links[$last]['url'];
        }

        return '';
    }

    protected function wrap($url, $title, $icon)
    {
        return array(
            'title' => $title,
            'url' => $url,
            'icon' => $icon,
        );
    }
}
