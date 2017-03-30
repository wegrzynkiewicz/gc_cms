<?php

/** Plik wejścia, ładuje aplikację i przetwarza żądanie */

require __DIR__.'/bootstrap.php';
require __DIR__.'/error-handler.php';

# obiekt reprezentujący żądanie
$request = GC\Request::createFromGlobals();
$request->detectLanguageCodes(array_keys($config['lang']['installed']));

# obiekt pomocniczy do generowania adresów URI
$uri = new GC\Uri($request);

# przekierowuje na prawidłowe adresy w razie potrzeby
$redirect = new GC\Redirect($request);
$redirect->ifSeoPolicyFaild($config['seo']);
$redirect->ifRewriteCorrect($config['rewrites']);

session_start();

$_SESSION['staff']['staff_id'] = 1; // TODO: usunąć, sprawia, że pracownik 1 jest zalogowany

if (isset($_REQUEST['allowInConstruction'])) {
    $_SESSION['allowInConstruction'] = true;
}

try {
    # jeżeli strona jest w budowie wtedy zwróć komunikat o budowie
    if ($config['debug']['construction'] and !isset($_SESSION['allowInConstruction'])) {
        throw new GC\Exception\ResponseException(null, 503); # Service Unavailable
    }

    $router = new GC\Router($request->method, (string) $request->slug, $request->extension);

    $_ACTION = $router->resolve();
    $_SEGMENTS = $router->segments;
    $_PARAMETERS = $router->parameters;

    logger('[ROUTING] '.relativePath($_ACTION));

    ob_start('ob_gzhandler');
    require $_ACTION;
    ob_end_flush();
}
catch (Throwable $exception) {

    if ($config['debug']['enabled']) {
        throw $exception;
    } else {
        logException($exception);
    }

    if ($exception instanceof GC\Exception\ResponseException) {
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
