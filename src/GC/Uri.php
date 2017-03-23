<?php

declare(strict_types=1);

namespace GC;

use League\Uri\Schemes\Http;
use League\Uri\Components\Host;
use League\Uri\Components\Path;
use League\Uri\Components\HierarchicalPath;

class Uri
{
    private $mask = '%s';
    private $request = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Generuje przednie części adresu dla plików w katalogu głównym
     */
    public function root(string $slug = ''): string
    {
        $uri = new Path($slug);
        $uri = $uri->withoutTrailingSlash();

        return (string) $this->request->root->append((string)$uri);
    }

    /**
     * Generuje przednie części adresu
     */
    public function make(string $slug): string
    {
        if ($slug === "#") {
            return $slug;
        }

        $uri = new HierarchicalPath($slug);
        if ($this->request->front) {
            $uri = $uri->prepend(Request::FRONT_CONTROLLER);
        }

        return $this->root((string)$uri);
    }

    /**
     * Generuje przednie części adresu
     */
    public function mask(string $slug = ''): string
    {
        return $this->make(sprintf($this->mask, $slug));
    }

    /**
     * Usuwa przednie części adresu, aby nie zawierały domeny lub rootUri
     */
    public function relative(string $url): string
    {
        $url = Http::createFromString($url);
        $uri = new HierarchicalPath($url->getPath());

        foreach ($this->request->root->getSegments() as $rootSegment) {
            $segment = $uri->getSegment(0);
            if ($segment !== $rootSegment) {
                break;
            }
            $uri = $uri->withoutSegments([0]);
        }

        $segment = $uri->getSegment(0);
        if ($segment === Request::FRONT_CONTROLLER) {
            $uri = $uri->withoutSegments([0]);
        }

        return (string) $uri;
    }

    /**
     */
    public function extendMask(string $mask): void
    {
        $this->mask = sprintf($this->mask, $mask);
    }
}
