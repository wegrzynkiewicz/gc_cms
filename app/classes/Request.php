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
        $rootUrl = dirname($_SERVER['SCRIPT_NAME']);
        $rawRequest = $_SERVER['REQUEST_URI'];
        $this->path = rtrim(parse_url($rawRequest, \PHP_URL_PATH), '/');
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);

        Data::get('logger')->request(
            $_SERVER['REQUEST_METHOD'].' '.$this->path, $_REQUEST
        );

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
}
