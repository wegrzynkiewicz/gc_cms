<?php

namespace GC\Debug;

class NullLogger
{
    public function __call($name, array $arguments)
    {
    }
}
