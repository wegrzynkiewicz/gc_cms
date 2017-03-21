<?php

/** Plik wejścia, ładuje aplikację i przetwarza żądanie */

require __DIR__.'/bootstrap.php';

# żądanie, obiekt uri jest tym samym żądaniem, tylko o krótszej nazwie
$uri = $request = new \GC\Request();

# przekierowuje na prawidłowe adresy w razie potrzeby
$request->redirectIfSeoUrlIsInvalid();
$request->redirectIfRewriteCorrect();

session_start();

if (isset($_REQUEST['allowInConstruction'])) {
    $_SESSION['allowInConstruction'] = true;
}

ob_start('ob_gzhandler') or ob_start();

try {
    # jeżeli strona jest w budowie wtedy zwróć komunikat o budowie
    if ($config['debug']['construction'] and !isset($_SESSION['allowInConstruction'])) {
        throw new \ResponseException(null, 503); # Service Unavailable
    }

    $router = new GC\Router($request->method, $request->slug);

    $_ACTION = $router->resolve();
    $_SEGMENTS = $router->segments;
    $_PARAMETERS = $router->parameters;

    logger('[ROUTING] '.relativePath($_ACTION));

    require $_ACTION;
}
catch (\GC\Exception\ResponseException $exception) {
    $code = $exception->getCode();
    $code = $code > 0 ? $code : 404; # Not Found
    echo renderError($code, [
        'message' => $exception->getMessage(),
    ]);
}
catch (\Exception $exception) {
    echo renderError(500); # Internal Server Error
}

ob_end_flush();

logger(sprintf('[RESPONSE] %s -- Time: %.3fs -- Memory: %sMiB',
    http_response_code(),
    microtime(true) - START_TIME,
    memory_get_peak_usage(true) / 1048576
));
