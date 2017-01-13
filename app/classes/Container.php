<?php

namespace GC;

use RuntimeException;

class Container
{
    private static $services = [];
    private static $lazyServices = [];

    public static function get($name)
    {
        if (isset(static::$lazyServices[$name])) {
            $callback = static::$lazyServices[$name];
            static::$services[$name] = $callback();
            unset(static::$lazyServices[$name]);
        }

        if (!isset(static::$services[$name])) {
            throw new RuntimeException(sprintf(
                'Service named (%s) does not exists', $name
            ));
        }

        return static::$services[$name];
    }

    public static function set($name, $service)
    {
        static::$services[$name] = $service;
    }

    public static function registerLazyService($name, $callback)
    {
        static::$lazyServices[$name] = $callback;
    }
}
