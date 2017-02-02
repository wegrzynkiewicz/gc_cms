<?php

/** Plik ładuje wszystkie niezbędne klasy, funkcje, oraz uruchamia aplikację */

# zarejestrowanie niestandardowego autoloadera klas
spl_autoload_register(function ($class) {
    # jeżeli nazwa klasy zaczyna się od GC\
    if (strpos($class, 'GC\\') === 0) {
        # utwórz ścieżkę składającą się z nazwy klasy i załaduj
        $path = __DIR__.'/classes/'.substr($class, 3).'.php';
        return require $path;
    }

    # jeżeli composer został załadowany wtedy zakończ
    if (defined('composer')) {
        return;
    }

    # załaduj komposera dopiero wtedy jeżeli każdy inny sposób zawiedzie
    $loader = require_once __DIR__.'/../vendor/autoload.php';
    $loader->loadClass($class);
    define('composer', true);
}, true, true);

require __DIR__.'/functions.php';
require __DIR__.'/services.php';
require __DIR__.'/redirects.php';

ob_start('ob_gzhandler') or ob_start();
require __DIR__.'/routing.php';
ob_end_flush();

$logger->info(sprintf('[RESPONSE] %s :: Time: %ss :: Memory: %sMiB',
    http_response_code(),
    microtime(true) - START_TIME,
    memory_get_peak_usage(true) / 1048576
));
