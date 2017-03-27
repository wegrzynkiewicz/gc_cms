<?php

declare(strict_types=1);

namespace GC\Validation;

use GC\Validation\Filter;
use GC\Exception\AssertException;

/**
 * Klasa Required rzuca wyjątek, jeżeli metoda filtrująca zawiedzie.
 * Ponadto pierwszym argumentem jest zawsze element tablicy $_REQUEST.
 */
class Required
{
    /**
     * Jest uruchamiana w momencie wywołania metody chronionej lub nieistniejącej.
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $element = array_shift($arguments);
        $value = $_REQUEST[$element] ?? null;
        array_unshift($arguments, $value);

        $value = call_user_func_array([Filter::class, $name], $arguments);

        return $value;
    }
}
