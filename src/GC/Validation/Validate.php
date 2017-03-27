<?php

declare(strict_types=1);

namespace GC\Validation;

use GC\Validation\Assert;
use GC\Exception\AssertException;

/**
 * Każda metoda statyczna klasy Validate zwraca bool
 */
class Validate
{
    /**
     * Jest uruchamiana w momencie wywołania metody chronionej lub nieistniejącej.
     */
    public static function __callStatic(string $name, array $arguments)
    {
        try {
            call_user_func_array([Assert::class, $name], $arguments);
        } catch (AssertException $exception) {
            return false;
        }

        return true;
    }
}
