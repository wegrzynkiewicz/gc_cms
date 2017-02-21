<?php

/** Plik wejścia, ładuje aplikację i przetwarza żądanie */

require __DIR__.'/bootstrap.php';

# żądanie, obiekt uri jest tym samym żądaniem, tylko o krótszej nazwie
$uri = $request = new GC\Request();

# przekierowuje na prawidłowe adresy w razie potrzeby
$request->redirectIfSeoUrlIsInvalid();
$request->redirectIfRewriteCorrect();

# jeżeli strona jest w budowie wtedy zwróć komunikat o budowie, chyba, że masz uprawnienie
if ($config['debug']['inConstruction']) {
    if (isset($_REQUEST['you-shall-not-pass'])) {
        $_SESSION['allowInConstruction'] = true;
    }
    if (!isset($_SESSION['allowInConstruction'])) {
        logger('[RESPONSE] inConstruction');
        require TEMPLATE_PATH.'/errors/construction.html.php';
        exit;
    }
}

session_start();

ob_start('ob_gzhandler') or ob_start();
require __DIR__.'/routing.php';
ob_end_flush();

logger(sprintf('[RESPONSE] %s -- Time: %.3fs -- Memory: %sMiB',
    http_response_code(),
    microtime(true) - START_TIME,
    memory_get_peak_usage(true) / 1048576
));
