<?php

/** Plik wejścia, ładuje aplikację i przetwarza żądanie */

require __DIR__.'/bootstrap.php';
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
