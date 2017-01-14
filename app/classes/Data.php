<?php

namespace GC;

use RuntimeException;

class Data
{
    public static $config;

    private static $services = [];
    private static $lazyServices = [];

    public static function get($name)
    {
        if (isset(static::$services[$name])) {
            return static::$services[$name];
        }

        if (isset(static::$lazyServices[$name])) {
            $callback = static::$lazyServices[$name];
            unset(static::$lazyServices[$name]);

            return static::$services[$name] = $callback();
        }

        throw new RuntimeException(sprintf(
            'Service named (%s) does not exists', $name
        ));
    }

    public static function &getAllServices()
    {
        return static::$services;
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
