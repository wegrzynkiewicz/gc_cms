<?php

/* Bootstapuje aplikację */

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/functions.php';
require __DIR__.'/services.php';
//require __DIR__.'/error-handler.php';
require __DIR__.'/redirects.php';

session_start();

# sprawdzana jest weryfikacja csrf tokenu, chroni przed spreparowanymi żądaniami
// if (!$request->isMethod('GET') and isset($_SESSION['csrf_token'])) {
//     if (isset($_SERVER['HTTP_X_CSRFTOKEN']) && $_SERVER['HTTP_X_CSRFTOKEN'] === $_SESSION['csrf_token']) {
//         GC\Container::get('logger')->csrf("Token verified via header");
//     } elseif (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
//         GC\Container::get('logger')->csrf("Token verified via request");
//     } else {
//         GC\Container::get('logger')->csrf("Invalid token");
//         return http_response_code(403);
//     }
// }

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = GC\Auth\Password::random(80);
}

GC\Render::$shortcuts = [
    'action' => ROOT_PATH.'/actions',
    'template' => ROOT_PATH.'/templates/'.TEMPLATE,
];

require __DIR__.'/routing.php';

$logger->response(sprintf('%s :: Time: %ss :: Memory: %sMiB ::',
    http_response_code(),
    microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'],
    memory_get_peak_usage(true) / 1048576
));
