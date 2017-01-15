<?php

namespace GC;

use GC\Logger;

class Request
{
    const FRONT_CONTROLLER_URL = '/index.php';

    public $url = '';
    public $query = '';
    public $method = '';
    public static $rootUrl = '';
    public static $frontControllerUrl = '';

    public function __construct()
    {
        # pobierz wszystkie najistotniejsze informacje o żądaniu
        $rootUrl = dirname($_SERVER['SCRIPT_NAME']);
        $rawRequest = $_SERVER['REQUEST_URI'];
        $this->url = rtrim(parse_url($rawRequest, \PHP_URL_PATH), '/');
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);

        Data::get('logger')->request(
            $_SERVER['REQUEST_METHOD'].' '.$this->url, $_REQUEST
        );

        # jeżeli aplikacja jest zainstalowana w katalogu, wtedy pomiń ścieżkę katalogu
        if ($rootUrl and strpos($this->url, $rootUrl) === 0) {
            $this->url = substr($this->url, strlen($rootUrl));
            static::$rootUrl = $rootUrl;
        }

        # jeżeli ścieżka zawiera front controller, wtedy usuń go
        if (strpos($this->url, static::FRONT_CONTROLLER_URL) === 0) {
            $this->url = substr($this->url, strlen(static::FRONT_CONTROLLER_URL));
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
