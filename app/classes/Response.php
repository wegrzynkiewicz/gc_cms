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
     * Przekierowuje na zewnętrzny zadany adres
     */
    public static function absoluteRedirect($location, $code = 303)
    {
        http_response_code($code);
        header("Location: {$location}");

        Data::get('logger')->redirect(
            sprintf("%s %s :: Time: %ss :: Memory: %sMiB",
                $code,
                $location,
                microtime(true) - START_TIME,
                memory_get_peak_usage(true) / 1048576
            )
        );

        die();
    }

    /**
     * Przekierowuje na zadany adres
     */
    public static function redirect($location, $code = 303)
    {
        $url = Url::make($location);
        static::absoluteRedirect($url, $code);
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
