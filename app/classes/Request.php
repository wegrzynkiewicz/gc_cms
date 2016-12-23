<?php

namespace GC;

use GC\Logger;

class Request
{
    const FRONT_CONTROLLER_URL = '/index.php';

    public $path = '';
    public $query = '';
    public $method = '';
    public static $rootUrl = '';
    public static $frontControllerUrl = '';

    public function __construct()
    {
        # pobierz wszystkie najistotniejsze informacje o żądaniu
        $rootUrl = dirname(static::filterServer('SCRIPT_NAME'));
        $rawRequest = static::filterServer('REQUEST_URI');
        $this->path = '/'.trim(parse_url($rawRequest, \PHP_URL_PATH), '/');
        $this->query = parse_url($rawRequest, \PHP_URL_QUERY);
        $this->method = strtolower(static::filterServer('REQUEST_METHOD'));

        Logger::request(sprintf("%s %s",
            $this->method, rtrim("{$this->path}?{$this->query}", '?')
        ), $_REQUEST);

        # jeżeli aplikacja jest zainstalowana w katalogu, wtedy pomiń ścieżkę katalogu
        if ($rootUrl and strpos($this->path, $rootUrl) === 0) {
            $this->path = substr($this->path, strlen($rootUrl));
            static::$rootUrl = $rootUrl;
        }

        # jeżeli ścieżka zawiera front controller, wtedy usuń go
        if (strpos($this->path, static::FRONT_CONTROLLER_URL) === 0) {
            $this->path = substr($this->path, strlen(static::FRONT_CONTROLLER_URL));
            static::$frontControllerUrl = static::FRONT_CONTROLLER_URL;
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
     * Sprawdza czy wysłane żądanie jest AJAXem
     */
    public function isXHR()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            return strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        }

        return false;
    }

    /**
     * Filtruje własciwości w tablicy $_SERVER
     */
    public static function filterServer($name)
    {
        return filter_input(\INPUT_SERVER, $name, \FILTER_SANITIZE_SPECIAL_CHARS);
    }
}
