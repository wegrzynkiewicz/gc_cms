<?php

namespace GC;

use GC\Data;

class Render
{
    /**
     * Tworzy wrapper dla renderowania pliku
     */
    public static function file($templateName, array $arguments = [])
    {
        extract(Data::getAllServices());
        extract($arguments, EXTR_OVERWRITE);

        ob_start();
        require $templateName;

        return ob_get_clean();
    }
}
