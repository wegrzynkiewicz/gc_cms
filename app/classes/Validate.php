<?php

namespace GC;

use GC\Model\Frame as ModelFrame;

class Validate
{
    public static function column($string)
    {
        return preg_match("~^[a-z_]+$~", $string);
    }

    public static function installedLang($code)
    {
        return in_array($code, array_keys($GLOBALS['config']['langs']));
    }

    public static function ip($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    public static function slug($slug, $frame_id = 0)
    {
        $frame = ModelFrame::select()
            ->equals('slug', $slug)
            ->condition('frame_id != ?', $frame_id)
            ->fetch();

        return !$frame;
    }
}
