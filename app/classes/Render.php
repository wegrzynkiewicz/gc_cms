<?php

namespace GC;

use GC\Container;
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
        extract(Container::getAllServices());
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
    public static function __callStatic($name, array $arguments)
    {
        if (!isset(static::$shortcuts[$name])) {
            throw new RuntimeException("Not found shortcut named ({$name})");
        }

        if (empty($arguments)) {
            throw new RuntimeException("Method ({$name}) must have arguments");
        }

        $template = array_shift($arguments);
        $args = [];
        if (!empty($arguments)) {
            $args = array_shift($arguments);
        }

        return static::file($template, $args, static::$shortcuts[$name]);
    }
}
