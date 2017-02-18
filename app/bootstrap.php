<?php

/** Plik wejścia, ładuje autoloader klas, funkcje oraz uruchamia routing */

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/config/config.php';
require __DIR__.'/functions.php';

# niestandardowy łapacz błędów, na każdym rodzaju błędu rzuca wyjątek
set_error_handler(function ($severity, $msg, $file, $line, array $context) {
    logger("[ERROR] {$msg}", [$file, $line]);
    if ($severity & error_reporting()) {
        throw new ErrorException($msg, 0, $severity, $file, $line);
    }

    return false;
});

# niestandardowy łapacz wyjątków, zapisuje tylko wyjątki do loggera
set_exception_handler(function ($exception) {
    logException($exception);
    throw $exception;
});

# żądanie, obiekt uri jest tym samym żądaniem, tylko o krótszej nazwie
$uri = $request = new GC\Request(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI'],
    $_SERVER['SCRIPT_NAME']
);

require __DIR__.'/redirects.php';

session_start();

ob_start('ob_gzhandler') or ob_start();
require __DIR__.'/routing.php';
ob_end_flush();

logger(sprintf('[RESPONSE] %s -- Time: %.3fs -- Memory: %sMiB',
    http_response_code(),
    microtime(true) - START_TIME,
    memory_get_peak_usage(true) / 1048576
));
