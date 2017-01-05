<?php

namespace GC;

use GC\Validate;
use UnexpectedValueException;

class Assert
{
    /**
     * Jest uruchamiana w momencie wywołania metody chronionej lub nieistniejącej.
     */
    public static function __callStatic($methodName, array $arguments)
    {
        if (!call_user_func_array([Validate::class, $methodName], $arguments)) {
            throw new UnexpectedValueException('Valid');
        }
    }
}
