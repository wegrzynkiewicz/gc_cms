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


try {
    # jeżeli strona jest w budowie wtedy zwróć komunikat o budowie
    if ($config['debug']['construction'] and !isset($_SESSION['allowInConstruction'])) {
        throw new \GC\Exception\ResponseException(null, 503); # Service Unavailable
    }

    $router = new GC\Router($request->method, $request->slug);

    $_ACTION = $router->resolve();
    $_SEGMENTS = $router->segments;
    $_PARAMETERS = $router->parameters;

    logger('[ROUTING] '.relativePath($_ACTION));

    ob_start('ob_gzhandler');
    require $_ACTION;
    ob_end_flush();
}
catch (\Exception $exception) {
    logException($exception);

    if ($exception instanceof \GC\Exception\ResponseException) {
        $code = $exception->getCode();
        $code = $code > 0 ? $code : 404; # Not Found
    } else {
        $code = 500; # Internal Server Error
    }

    # usuń wszystkie utworzone buffory
    while (count(ob_get_status(true))) {
        ob_end_clean();
    }

    # wyświetl bład
    ob_start('ob_gzhandler');
    echo renderError($code, [
        'message' => $exception->getMessage(),
    ]);
    ob_end_flush();
}

logger(sprintf('[RESPONSE] %s -- Time: %.3fs -- Memory: %sMiB',
    http_response_code(),
    microtime(true) - START_TIME,
    memory_get_peak_usage(true) / 1048576
));
