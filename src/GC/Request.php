<?php

declare(strict_types=1);

namespace GC;

use League\Uri\Schemes\Http;
use League\Uri\Components\Host;
use League\Uri\Components\Path;
use League\Uri\Components\HierarchicalPath;

class Request
{
    const FRONT_CONTROLLER = 'index.php';

    public $method = 'GET';
    public $front = false;
    public $lang = '';
    public $extension = '';
    public $slug = null;
    public $root = null;
    public $url = null;
    public $uri = null;

    public function __construct(string $method, Http $url, HierarchicalPath $script)
    {
        $this->method = strtoupper($method);
        $this->url = $url;
        $this->url = $this->url->withUserInfo('');
        $this->url = $this->url->withPath('');
        $this->url = $this->url->withQuery('');
        $this->url = $this->url->withFragment('');

        $this->root = new HierarchicalPath($script->getDirname());
        $this->slug = new HierarchicalPath($url->getPath());
        $this->slug = $this->removeRootPath($this->slug);

        $this->extension = $this->slug->getExtension();
        $this->slug = $this->slug->withExtension('');
        $this->uri = (string) Http::createFromString()
            ->withPath($url->getPath())
            ->withQuery($url->getQuery());

        logger("[REQUEST] {$method} {$this->slug}", $_REQUEST);
        logger("[URL] {$url}");
    }

    public function detectLanguageCodes(array $languageCodes): void
    {
        $probablyLanguageCode = $this->slug->getSegment(0);
        foreach ($languageCodes as $languageCode) {
            if ($probablyLanguageCode === $languageCode) {
                $this->lang = $languageCode;
                break;
            }
        }
    }

    public function removeRootPath(HierarchicalPath $path): HierarchicalPath
    {
        foreach ($this->root->getSegments() as $rootSegment) {
            $segment = $path->getSegment(0);
            if ($segment !== $rootSegment) {
                break;
            }
            $path = $path->withoutSegments([0]);
        }

        if ($path->getSegment(0) === Request::FRONT_CONTROLLER) {
            $path = $path->withoutSegments([0]);
            $this->front = true;
        }

        return $path;
    }

    /**
     * Zwraca true jeżeli metoda żądania jest równa $method
     */
    public function isMethod(string $method): bool
    {
        return $this->method === strtolower($method);
    }

    /**
     * Zwraca pełny adres żądania
     */
    public static function createFromGlobals(): self
    {
        return new static(
            $_SERVER['REQUEST_METHOD'],
            Http::createFromServer($_SERVER),
            new HierarchicalPath($_SERVER['SCRIPT_NAME'])
        );
    }
}
