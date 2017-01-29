<?php

namespace GC;

class Validate
{
    public static function column($string)
    {
        return preg_match("~^[a-z_]+$~", $string);
    }

    public static function installedLang($code)
    {
        return in_array($code, array_keys(getConfig()['langs']));
    }

    public static function ip($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP);
    }
}
