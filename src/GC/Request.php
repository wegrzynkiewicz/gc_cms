<?php

declare(strict_types=1);

namespace GC;

use League\Uri\Schemes\Http;
use League\Uri\Components\Host;
use League\Uri\Components\HierarchicalPath;

class Request
{
    const FRONT_CONTROLLER = 'index.php';

    public $method = 'GET';
    public $front = false;
    public $lang = '';
    public $extension = '';
    public $slug = '';
    public $root = null;
    public $url = null;
    public $uri = null;

    public function __construct(string $method, Http $url, HierarchicalPath $script)
    {
        $this->method = strtoupper($method);
        $this->url = $url;

        $this->root = $script->withoutSegments([-1]);
        $this->slug = new HierarchicalPath($url->getPath());
        $this->slug = $this->slug->withoutSegments($this->root->keys());

        if ($this->slug->getSegment(0) === static::FRONT_CONTROLLER) {
            $this->slug = $this->slug->withoutSegments([0]);
            $this->front = true;
        }

        $this->extension = $this->slug->getExtension() ?: 'html';
        $this->slug = $this->slug->withExtension('');
        $this->uri = (string) Http::createFromString()
            ->withPath($this->url->getPath())
            ->withQuery($this->url->getQuery());

        logger("[URL] {$url}");
        logger("[REQUEST] {$method} {$this->slug}", $_REQUEST);
    }

    public function detectLanguage(array $languageCodes): void
    {
        $propablyLanguageCode = $this->slug->getSegment(0);
        foreach ($languageCodes as $languageCode) {
            if ($propablyLanguageCode === $languageCode) {
                $this->slug = $this->slug->withoutSegments([0]);
                $this->lang = $languageCode;
                break;
            }
        }
    }

    /**
     * Zwraca true jeżeli metoda żądania jest równa $method
     */
    public function isMethod(string $method): boolean
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
