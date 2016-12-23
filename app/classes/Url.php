<?php

namespace GC;

use GC\Request;

class Url
{
    private static $mask = '%s';

    /**
     * Generuje przednie części adresu dla plików w katalogu głównym
     */
    public static function root($path)
    {
        return Request::$rootUrl.$path; # generowane przez routing
    }

    /**
     * Generuje przednie części adresu dla plików nieźródłowych
     */
    public static function assets($path)
    {
        return static::root(ASSETS_URL.$path);
    }

    /**
     * Generuje przednie części adresu dla plików nieźródłowych w szablonie
     */
    public static function templateAssets($path)
    {
        return static::root(TEMPLATE_ASSETS_URL.$path);
    }

    /**
     * Generuje przednie części adresu
     */
    public static function make($path)
    {
        if ($path === "#") {
            return $path;
        }

        return static::root(Request::$frontControllerUrl.$path);
    }

    /**
     * Generuje przednie części adresu
     */
    public static function mask($path = '')
    {
        return static::make(sprintf(static::$mask, $path));
    }

    /**
     * Usuwa przednie części adresu, aby nie zawierały domeny lub rootUrl
     */
    public static function upload($path)
    {
        if (strlen(ROOT_URL) <= 0) {
            return $path;
        }

        if ($path and strpos($path, ROOT_URL) === 0) {
            $path = substr($path, strlen(ROOT_URL));
        }

        return $path;
    }

    /**
     */
    public static function extendMask($mask)
    {
        static::$mask = sprintf(static::$mask, $mask);
    }
}
