<?php

namespace GC;

class Request
{
    const FRONT_CONTROLLER_URL = '/index.php';

    public $method = 'GET';
    public $protocol = '';
    public $host = 'localhost';
    public $www = false;
    public $domain = '';
    public $port = 80;
    public $uri = '';
    public $query = '';

    public $rootUrl = '';
    public $frontControllerUrl = '';
    public $lang = '';
    public $slug = '';

    public $mask = '%s';

    public function __construct()
    {
        # pobranie najważniejszych danych o adresie strony
        $this->method = strtolower(server('REQUEST_METHOD', 'GET'));
        $this->protocol = 'http'.(stripos(server('SERVER_PROTOCOL', 'http'), 'https') === true ? 's' : '');
        $this->host = server('HTTP_HOST', 'localhost');
        $this->www = substr($this->host, 0, 4) === 'www.';
        $this->doslug = server('SERVER_NAME', $this->host);
        $this->port = intval(server('SERVER_PORT', 80));
        $this->uri = parse_url(server('REQUEST_URI'), \PHP_URL_PATH);
        $this->query = parse_url(server('REQUEST_URI'), \PHP_URL_QUERY);

        # pobierz wszystkie najistotniejsze informacje o żądaniu
        $rootUrl = dirname(server('SCRIPT_NAME'));
        dd($_SERVER);
        dd($rootUrl);
        $this->slug = $this->uri;

        logger('[REQUEST] '.strtoupper($this->method).' '.$this->slug, $_REQUEST);

        # jeżeli aplikacja jest zainstalowana w katalogu, wtedy pomiń ścieżkę katalogu
        if ($rootUrl and strpos($this->slug, $rootUrl) === 0) {
            $this->slug = substr($this->slug, strlen($rootUrl));
            $this->rootUrl = $rootUrl;
        }

        # jeżeli ścieżka zawiera front controller, wtedy usuń go
        if (strpos($this->slug, static::FRONT_CONTROLLER_URL) === 0) {
            $this->slug = substr($this->slug, strlen(static::FRONT_CONTROLLER_URL));
            $this->frontControllerUrl = static::FRONT_CONTROLLER_URL;
        }

        # sprawdza pierwszy segment w adresie czy nie jest jednym z dostępnych języków
        foreach ($GLOBALS['config']['langs'] as $code => $lang) {
            if (strpos($this->slug, "/{$code}/") === 0 or $this->slug === "/{$code}") {
                $this->lang = $code;
            }
        }

        # slug musi mieć zawsze slasha na początku
        $this->slug = '/'.trim($this->slug, '/');
    }

    /**
     * Zwraca pełny adres żądania
     */
    public function getUrl()
    {
        $www = $this->www ? 'www.' : '';
        $port = $this->port === 80 ? '' : ":{$this->port}";
        $uri = $this->uri === '/' ? '' : $this->uri;

        $url = "{$this->protocol}://{$www}{$this->domain}{$port}{$uri}?{$this->query}";
        $url = rtrim($url, '?');

        return $url;
    }

    /**
     * Przekierowuje na inny adres jeżeli adres url żądania nie zgadza się z polityką seo
     */
    public function redirectIfSeoUrlIsInvalid()
    {
        $target = clone $this;
        $seo = $GLOBALS['config']['seo'];

        if ($seo['forceHTTPS'] !== null) {
            $target->protocol = 'http'.((bool)$seo['forceHTTPS'] ? 's' : '');
        }

        if ($seo['forceWWW'] !== null) {
            $target->www = (bool)$seo['forceWWW'];
        }

        if ($seo['forceDomain'] !== null) {
            $target->domain = $seo['forceDomain'];
        }

        if ($seo['forcePort'] !== null) {
            $target->port = intval($seo['forcePort']);
        }

        $targetUrl = $target->getUrl();
        $currentUrl = $this->getUrl();

        # przekierowanie na prawidłowy adres
        if ($currentUrl !== $targetUrl) {
            logger("[SEO] From: {$currentUrl} To: {$targetUrl}");
            absoluteRedirect($targetUrl, 301);  # 301 Moved Permanently
        }
    }

    /**
     * Przekierowuje jeżeli któryś z niestandardowych rewritów okaże się pasować
     */
    public function redirectIfRewriteCorrect()
    {
        $target = "{$this->slug}?{$this->query}";
        $target = rtrim($target, '?');
        foreach ($GLOBALS['config']['rewrites'] as $pattern => $destination) {
            if (preg_match($pattern, $target)) {
                $result = preg_replace($pattern, $destination, $target);
                redirect($result, 301); # 301 Moved Permanently
            }
        }
    }

    /**
     * Zwraca true jeżeli metoda żądania jest równa $method
     */
    public function isMethod($method)
    {
        return $this->method === strtolower($method);
    }

    /**
     * Generuje przednie części adresu dla plików w katalogu głównym
     */
    public function root($uri = '')
    {
        return '/'.trim($this->rootUrl.$uri, '/');
    }

    /**
     * Generuje przednie części adresu dla plików nieźródłowych
     */
    public function assets($uri)
    {
        return $this->rootUrl.ASSETS_URL.$uri;
    }

    /**
     * Generuje przednie części adresu dla plików nieźródłowych w szablonie
     */
    public function templateAssets($uri)
    {
        return $this->rootUrl.TEMPLATE_ASSETS_URL.$uri;
    }

    /**
     * Generuje przednie części adresu
     */
    public function make($uri)
    {
        if ($uri === "#") {
            return $uri;
        }

        return $this->root($this->frontControllerUrl.$uri);
    }

    /**
     * Generuje przednie części adresu
     */
    public function mask($uri = '')
    {
        return $this->make(sprintf($this->mask, $uri));
    }

    /**
     * Usuwa przednie części adresu, aby nie zawierały domeny lub rootUrl
     */
    public function relative($uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        if (strlen($this->rootUrl) <= 0) {
            return $uri;
        }

        if ($uri and strpos($uri, $this->rootUrl) === 0) {
            $uri = substr($uri, strlen($this->rootUrl));
        }

        return $uri;
    }

    /**
     * Generuje pełen adres do zasobu wraz z domeną
     */
    public function absolute($uri)
    {
        $uri = $this->make($uri);
        $url = "{$this->protocol}://{$this->host}{$uri}";

        return $url;
    }

    /**
     */
    public function extendMask($mask)
    {
        $this->mask = sprintf($this->mask, $mask);
    }
}
