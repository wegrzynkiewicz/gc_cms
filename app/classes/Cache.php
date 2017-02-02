<?php

namespace GC;

class Cache
{
    /**
     * Odczytuje cache sesyjny o nazwie $name i czasie życia mniejszym niż $ttl
     * wyrażanym w sekundach. Jeżeli trzeba odświeżyć wartość wtedy wywołuje
     * przekazanego $callback i zapisuje rezultat funkcji w cachu
     */
    public static function session($name, $ttl, $callback)
    {
        # spróbuj pobrać tablice z sesji
        $pool = getValueByKeys($_SESSION, ['cache', $name], null);

        # jeżeli istnieje skeszowany $pool wtedy zwróć
        if ($pool and $pool['expires'] > time()) {
            logger("[CACHE] {$name} was load from cache");

            # zwróć skeszowane dane
            return $_SESSION['cache'][$name]['data'];
        }

        # wywołaj długi callback
        $result = $callback();

        # zapisz w sesji dane, czyli skeszuj
        $_SESSION['cache'][$name] = [
            'data' => $result,
            'expires' => time() + $ttl,
        ];

        logger("[CACHE] {$name} was regenerate");

        # zwróć wytworzone dane
        return $result;
    }
}
