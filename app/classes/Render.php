<?php

namespace GC;

use RuntimeException;

class Render
{
    public static $extract = [];
    public static $shortcuts = [];

    /**
     * Tworzy wrapper dla renderowania pliku
     */
    public static function file($templateName, array $arguments = [], $prefix = '')
    {
        extract(static::$extract);
        extract($arguments, EXTR_OVERWRITE);

        ob_start();
        require $prefix.$templateName;

        return ob_get_clean();
    }

    /**
     * Jest uruchamiana w momencie wywołania nieistniejącej metody.
     * Sprawdza czy w tablicy $shortcuts zawiera się nazwa metody.
     * Jeżeli tak, to wtedy wywołuje metodę static::file,
     * a jako prefix przekazuje wartość z tablicy $shortcuts.
     */
    public static function __callStatic($methodName, array $arguments)
    {
        print_r($GLOBALS);

        if (!isset(static::$shortcuts[$methodName])) {
            throw new RuntimeException("Not found shortcut named ({$methodName})");
        }

        if (empty($arguments)) {
            throw new RuntimeException("Method ({$methodName}) must have arguments");
        }

        $template = array_shift($arguments);
        $args = [];
        if (!empty($arguments)) {
            $args = array_shift($arguments);
        }

        return static::file($template, $args, static::$shortcuts[$methodName]);
    }
}
