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

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Generuje przednie części adresu dla plików w katalogu głównym
     */
    public function root(string $slug = '', array $query = []): string
    {
        $path = new HierarchicalPath($slug);
        $path = $path->prepend((string) $this->request->root);

        $path = new Path((string)$path);
        $path = $path->withoutTrailingSlash();

        $query = Query::createFromPairs($query);
        $uri = Http::createFromString((string) $path);
        $uri = $uri->withQuery((string)$query);

        return (string) $uri;
    }

    /**
     * Generuje przednie części adresu
     */
    public function make(string $slug, array $query = []): string
    {
        if ($slug === "#") {
            return $slug;
        }

        $path = new HierarchicalPath($slug);
        if ($this->request->front) {
            $path = $path->prepend(Request::FRONT_CONTROLLER);
        }

        return $this->root((string)$path, $query);
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
