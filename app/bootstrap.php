<?php

/** Plik ładuje wszystkie niezbędne klasy, funkcje, oraz uruchamia aplikację */

require __DIR__.'/../vendor/autoload.php';
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
