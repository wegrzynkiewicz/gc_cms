<?php

namespace GC\Debug;

class NullLogger
{
    public static function __call($name, array $arguments)
    {
    }
}
