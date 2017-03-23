<?php

declare(strict_types=1);

namespace GC;

use GC\Validate;
use Exception;

class Assert
{
    /**
     * Jest uruchamiana w momencie wywołania metody chronionej lub nieistniejącej.
     */
    public static function __callStatic(string $name, array $arguments)
    {
        if (!call_user_func_array([Validate::class, $name], $arguments)) {
            throw new Exception();
        }
    }
}
