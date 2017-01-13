<?php

namespace GC;

use GC\Url;
use GC\Logger;

class Response
{
    /**
     * Ustawia mime type, jeżeli nagłówek nie został jeszcze wysłany
     */
    public static function setMimeType($mimeType)
    {
        if (!headers_sent()) {
            header("Content-Type: {$mimeType}; charset=utf-8");
        }
    }

    /**
     * Przekierowuje na zadany adres
     */
    public static function redirect($location, $code = 303)
    {
        $url = Url::make($location);

        http_response_code($code);
        header("Location: {$url}");

        Container::get('logger')->redirect(
            sprintf("%s %s :: Time: %ss :: Memory: %sMiB",
                $code,
                $url,
                microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'],
                memory_get_peak_usage(true) / 1048576
            )
        );

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
