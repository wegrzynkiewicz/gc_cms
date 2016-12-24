<?php

namespace GC;

use GC\Url;
use GC\Logger;

class Response
{
    /**
     * Przekierowuje na zadany adres
     */
    public static function redirect($location, $code = 303)
    {
        $url = Url::make($location);

        http_response_code($code);
        header("Location: {$url}");

        Logger::redirect(
            sprintf("%s %s :: ExecutionTime: %s", $code, $url, (microtime(true) - START_TIME)
        ));

        die();
    }

    /**
     * Przekierowuje na adres z ktorego nastąpiło wejście lub na podany w parametrze
     */
    public static function redirectToRefererOrDefault($defaultLocation, $code = 303)
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
            $referer = parse_url($referer, PHP_URL_PATH);
            static::redirect($referer, $code);
        }

        static::redirect($defaultLocation, $code);
    }
}
