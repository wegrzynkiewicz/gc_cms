<?php

/** Plik ładuje autoloader klas oraz funkcje */

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/etc/config.php';
require __DIR__.'/functions.php';

# niestandardowy łapacz błędów, na każdym rodzaju błędu rzuca wyjątek
set_error_handler(function ($severity, $msg, $file, $line, array $context) {
    logger("[ERROR] {$msg}", [relativePath($file), $line]);
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
