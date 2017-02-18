<?php

namespace GC;

class Request
{
    const FRONT_CONTROLLER_URL = '/index.php';

    public $uri = '';
    public $query = '';
    public $method = '';
    public $rootUrl = '';
    public $frontControllerUrl = '';
    public $mask = '%s';
    public $lang = null;
    public $rawUri = '';

    public function __construct($method, $rawUri, $script)
    {
        # pobierz wszystkie najistotniejsze informacje o żądaniu
        $rootUrl = dirname($script);
        $this->rawUri = $rawUri;
        $this->uri = parse_url($rawUri, \PHP_URL_PATH);
        $this->method = strtolower($method);

        logger('[REQUEST] '.strtoupper($method).' '.$this->uri, $_REQUEST);

        # jeżeli aplikacja jest zainstalowana w katalogu, wtedy pomiń ścieżkę katalogu
        if ($rootUrl and strpos($this->uri, $rootUrl) === 0) {
            $this->uri = substr($this->uri, strlen($rootUrl));
            $this->rootUrl = $rootUrl;
        }

        # jeżeli ścieżka zawiera front controller, wtedy usuń go
        if (strpos($this->uri, static::FRONT_CONTROLLER_URL) === 0) {
            $this->uri = substr($this->uri, strlen(static::FRONT_CONTROLLER_URL));
            $this->frontControllerUrl = static::FRONT_CONTROLLER_URL;
        }

        # sprawdza pierwszy segment w adresie czy nie jest jednym z dostępnych języków
        foreach ($GLOBALS['config']['langs'] as $code => $lang) {
            if (strpos($this->uri, "/{$code}/") === 0 or $this->uri === "/{$code}") {
                $this->uri = substr($this->uri, strlen("/{$code}"));
                $this->lang = $code;
            }
        }

        # uri musi mieć zawsze slasha na początku
        $this->uri = '/'.trim($this->uri, '/');
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
    public function root($path = '')
    {
        return '/'.trim($this->rootUrl.$path, '/');
    }

    /**
     * Generuje przednie części adresu dla plików nieźródłowych
     */
    public function assets($path)
    {
        return $this->rootUrl.ASSETS_URL.$path;
    }

    /**
     * Generuje przednie części adresu dla plików nieźródłowych w szablonie
     */
    public function templateAssets($path)
    {
        return $this->rootUrl.TEMPLATE_ASSETS_URL.$path;
    }

    /**
     * Generuje przednie części adresu
     */
    public function make($path)
    {
        if ($path === "#") {
            return $path;
        }

        return $this->root($this->frontControllerUrl.$path);
    }

    /**
     * Generuje przednie części adresu
     */
    public function mask($path = '')
    {
        return $this->make(sprintf($this->mask, $path));
    }

    /**
     * Usuwa przednie części adresu, aby nie zawierały domeny lub rootUrl
     */
    public function relative($path)
    {
        if (strlen($this->rootUrl) <= 0) {
            return $path;
        }

        if ($path and strpos($path, $this->rootUrl) === 0) {
            $path = substr($path, strlen($this->rootUrl));
        }

        return $path;
    }

    /**
     */
    public function extendMask($mask)
    {
        $this->mask = sprintf($this->mask, $mask);
    }
}
