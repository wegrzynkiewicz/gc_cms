<?php

declare(strict_types=1);

namespace GC\Validation;

use GC\Validation\Assert;
use GC\Exception\AssertException;

/**
 * Klasa Filter zwraca null, jeżeli metoda walidująca zwróci false.
 */
class Filter
{
    /**
     * Jest uruchamiana w momencie wywołania metody chronionej lub nieistniejącej.
     */
    public static function __callStatic(string $name, array $arguments)
    {
        call_user_func_array([Assert::class, $name], $arguments);

        return array_shift($arguments);
    }

    public static function purify(string $dirtyHtml): string
    {
        $config = \HTMLPurifier_Config::createDefault();
        $purifier = new \HTMLPurifier($config);
        $cleanHtml = $purifier->purify($dirtyHtml);

        return $cleanHtml;
    }
}
