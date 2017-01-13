<?php

namespace GC;

use GC\Validate;
use UnexpectedValueException;

class Assert
{
    /**
     * Jest uruchamiana w momencie wywołania metody chronionej lub nieistniejącej.
     */
    public static function __callStatic($name, array $arguments)
    {
        if (!call_user_func_array([Validate::class, $name], $arguments)) {
            throw new UnexpectedValueException('Valid');
        }
    }
}
