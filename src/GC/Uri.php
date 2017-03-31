<?php

declare(strict_types=1);

namespace GC;

use League\Uri\Schemes\Http;
use League\Uri\Components\Host;
use League\Uri\Components\Path;
use League\Uri\Components\Query;
use League\Uri\Components\HierarchicalPath;

class Uri
{
    private $request = null;
    private $root = '';
    private $front = '';

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->root = rtrim((string) $this->request->root, '/');
        if ($this->request->front) {
            $this->front = '/'.Request::FRONT_CONTROLLER;
        }
    }

    /**
     * Generuje przednie części adresu dla plików w katalogu głównym
     */
    public function root(string $slug = ''): string
    {
        return $this->root.$slug;
    }

    /**
     * Generuje przednie części adresu
     */
    public function make(string $slug): string
    {
        if ($slug === "#") {
            return $slug;
        }

        return $this->root.$this->front.$slug;
    }

    /**
     * Usuwa przednie części adresu, aby nie zawierały domeny lub rootUri
     */
    public function relative(string $url): string
    {
        $url = Http::createFromString($url);
        $path = new HierarchicalPath($url->getPath());
        $path = $this->request->removeRootPath($path);

        return (string) $path;
    }
}
