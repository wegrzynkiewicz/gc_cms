<?php

/** Plik wejścia, ładuje aplikację i przetwarza żądanie */

require __DIR__.'/bootstrap.php';

# żądanie, obiekt uri jest tym samym żądaniem, tylko o krótszej nazwie
$uri = $request = new GC\Request();

# przekierowuje na prawidłowe adresy w razie potrzeby
$request->redirectIfSeoUrlIsInvalid();
$request->redirectIfRewriteCorrect();

session_start();

if (isset($_REQUEST['allowInConstruction'])) {
    $_SESSION['allowInConstruction'] = true;
}

ob_start('ob_gzhandler') or ob_start();

# jeżeli strona jest w budowie wtedy zwróć komunikat o budowie
if ($config['debug']['construction'] and !isset($_SESSION['allowInConstruction'])) {
    echo renderError(503);
} else {
    $router = new GC\Router($request->method, $request->slug);

    $_ACTION = $router->resolve();
    $_PARAMETERS = $router->parameters;
    $_SEGMENTS = $router->segments;

    if ($_ACTION === null) {
        echo renderError(404);
    } else {
        require $_ACTION;
    }
}

ob_end_flush();

logger(sprintf('[RESPONSE] %s -- Time: %.3fs -- Memory: %sMiB',
    http_response_code(),
    microtime(true) - START_TIME,
    memory_get_peak_usage(true) / 1048576
));
