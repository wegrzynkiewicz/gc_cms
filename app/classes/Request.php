<?php

namespace GC;

class Request
{
    const FRONT_CONTROLLER_URI = '/index.php';

    public $method = 'GET';
    public $protocol = '';
    public $host = 'localhost';
    public $www = false;
    public $domain = '';
    public $port = 80;
    public $uri = '';
    public $root = '';
    public $frontController = false;
    public $lang = '';
    public $extension = '';
    public $query = '';

    public $slug = '';
    public $mask = '%s';
    public $defaultExtension = '';

    public function __construct()
    {
        # pobranie najważniejszych danych o adresie strony
        $this->method = strtolower(server('REQUEST_METHOD', 'GET'));
        $this->protocol = 'http'.(stripos(server('SERVER_PROTOCOL', 'http'), 'https') === true ? 's' : '');
        $this->host = server('HTTP_HOST', 'localhost');
        $this->www = substr($this->host, 0, 4) === 'www.';
        $this->domain = server('SERVER_NAME', $this->host);
        $this->port = intval(server('SERVER_PORT', 80));
        $this->uri = parse_url(server('REQUEST_URI'), \PHP_URL_PATH);
        $this->query = parse_url(server('REQUEST_URI'), \PHP_URL_QUERY);

        # pobranie domyślnego rozszerzenia z polityki seo
        $this->defaultExtension = $GLOBALS['config']['seo']['forceDefaultExtension'];

        # pobierz wszystkie najistotniejsze informacje o żądaniu
        $rootUri = dirname(server('SCRIPT_NAME'));
        $this->slug = $this->uri;

        logger('[REQUEST] '.strtoupper($this->method).' '.$this->slug, $_REQUEST);

        # jeżeli aplikacja jest zainstalowana w katalogu, wtedy pomiń ścieżkę katalogu
        if ($rootUri and strpos($this->slug, $rootUri) === 0) {
            $this->slug = substr($this->slug, strlen($rootUri));
            $this->root = $rootUri;
        }

        # jeżeli adres zawiera front controller, wtedy usuń go
        if (strpos($this->slug, static::FRONT_CONTROLLER_URI) === 0) {
            $this->slug = substr($this->slug, strlen(static::FRONT_CONTROLLER_URI));
            $this->frontController = true;
        }

        # sprawdza pierwszy segment w adresie czy nie jest jednym z dostępnych języków
        foreach ($GLOBALS['config']['langs'] as $code => $lang) {
            if (strpos($this->slug, "/{$code}/") === 0 or $this->slug === "/{$code}") {
                $this->lang = $code;
            }
        }

        # pozyskaj rozszerzenie ze sluga
        $this->extension = pathinfo($this->slug, PATHINFO_EXTENSION);

        # jeżeli adres zawiera rozszerzenie HTML_EXTENSION, wtedy usuń je
        if ($this->extension === $this->defaultExtension) {
            $this->slug = substr($this->slug, 0, -strlen($this->defaultExtension));
        }

        # slug musi mieć zawsze slasha na początku, bez kropek ani myślników
        $this->slug = '/'.trim($this->slug, '/.-');
    }

    /**
     * Zwraca pełny adres żądania
     */
    public function getUrl()
    {
        $www = $this->www ? 'www.' : '';
        $port = $this->port === 80 ? '' : ":{$this->port}";
        $slug = $this->slug === '/' ? '' : $this->slug;
        $extension = $this->extension === $this->defaultExtension ? '.'.$this->defaultExtension : '';
        $front = $this->frontController ? static::FRONT_CONTROLLER_URI : '';

        $url = "{$this->protocol}://{$www}{$this->domain}{$port}{$this->root}{$front}{$slug}{$extension}?{$this->query}";
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

        if ($seo['forceIndexPhp'] !== null) {
            $target->frontController = (bool)$seo['forceIndexPhp'];
        }

        if ($seo['forcePort'] !== null) {
            $target->port = intval($seo['forcePort']);
        }

        if ($seo['forcePort'] !== null) {
            $target->port = intval($seo['forcePort']);
        }

        if ($seo['forceDefaultExtension'] !== null) {
            $target->extension = $seo['forceDefaultExtension'] ? $seo['forceDefaultExtension'] : '';
        }

        $targetUrl = $target->getUrl();
        $currentUrl = $this->getUrl();

        # przekierowanie na prawidłowy adres
        if ($currentUrl !== $targetUrl) {
            logger("[SEO] From: {$currentUrl} To: {$targetUrl}");
            redirect($targetUrl, $seo['responseCode']);
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
        return '/'.trim($this->root.$uri, '/');
    }

    /**
     * Generuje przednie części adresu dla plików nieźródłowych
     */
    public function assets($uri)
    {
        return $this->root.ASSETS_URL.$uri;
    }

    /**
     * Generuje przednie części adresu dla plików nieźródłowych w szablonie
     */
    public function templateAssets($uri)
    {
        return $this->root.TEMPLATE_ASSETS_URL.$uri;
    }

    /**
     * Generuje przednie części adresu
     */
    public function make($uri)
    {
        if ($uri === "#") {
            return $uri;
        }

        $uri = rtrim($this->root.$uri, '/');
        $front = $this->frontController ? static::FRONT_CONTROLLER_URI : '';
        $extension = $this->extension === $this->defaultExtension ? '.'.$this->defaultExtension : '';

        return $this->root($front.$uri.$extension);
    }

    /**
     * Generuje przednie części adresu
     */
    public function mask($uri = '')
    {
        return $this->make(sprintf($this->mask, $uri));
    }

    /**
     * Usuwa przednie części adresu, aby nie zawierały domeny lub rootUri
     */
    public function relative($uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        if (strlen($this->root) <= 0) {
            return $uri;
        }

        if ($uri and strpos($uri, $this->root) === 0) {
            $uri = substr($uri, strlen($this->root));
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
