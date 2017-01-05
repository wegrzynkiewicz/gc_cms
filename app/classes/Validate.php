<?php

namespace GC;

class Validate
{
    public static function column($string)
    {
        return preg_match("~^[a-z_]+$~", $string);
    }
}
