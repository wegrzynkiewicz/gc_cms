<?php

/* Bootstapuje aplikację */

define('START_TIME', microtime(true));

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/config/config.php';
require __DIR__.'/functions.php';
//require __DIR__.'/error-handler.php';

chdir('..'); # zmienia bieżący katalog o jeden poziom wyżej niż web root

ini_set('session.cookie_httponly', 1); # ustawia ciastko tylko do odczytu, nie jest możliwe odczyt document.cookie w js
ini_set('session.use_cookies', 1); # do przechowywania sesji ma użyć ciastka
ini_set('session.use_only_cookies', 1); # do przechowywania sesji ma używać tylko ciastka!

session_name($config['session']['cookieName']); # zmień nazwę ciasteczka sesyjnego
session_start();

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = [];
}

header('X-Content-Type-Options: nosniff'); # Nie pozwala przeglądarce na zgadywanie typu mime nieznanego pliku
header('X-XSS-Protection: 1; mode=block'); # ustawienie ochrony przeciw XSS, przeglądarka sama wykrywa XSSa

header_remove('X-Powered-By');
setHeaderMimeType('text/html');
date_default_timezone_set($config['timezone']);

if ($config['debug']['enabled']) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
}

GC\Storage\Database::initialize($config['db']);

$request = new GC\Request(); # tworzy obiekt reprezentujący żądanie

# jeżeli strona jest w budowie wtedy zwróć komunikat o budowie, chyba, że masz uprawnienie
if ($config['debug']['inConstruction']) {
    if (isset($_REQUEST['you-shall-not-pass'])) {
        $_SESSION['allowInConstruction'] = true;
    }
    if (!isset($_SESSION['allowInConstruction'])) {
        $constructionPath = TEMPLATE_PATH.'/errors/construction.html.php';
        if (is_readable(TEMPLATE_PATH.'/errors/construction.html.php')) {
            return require $constructionPath;
        }
        http_response_code(503);
    }
}

# sprawdzana jest weryfikacja csrf tokenu, chroni przed spreparowanymi żądaniami
if (!$request->isMethod('GET') and isset($_SESSION['csrf_token'])) {
    if (isset($_SERVER['HTTP_X_CSRFTOKEN']) && $_SERVER['HTTP_X_CSRFTOKEN'] === $_SESSION['csrf_token']) {
        GC\Logger::csrf("Token verified via header");
    } elseif (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        GC\Logger::csrf("Token verified via request");
    } else {
        GC\Logger::csrf("Invalid token");
        return http_response_code(403);
    }
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = GC\Password::random(80);
}

GC\Render::$extract = [
    'config' => $config,
    'request' => $request,
];

GC\Render::$shortcuts = [
    'action' => ROOT_PATH.'/actions',
    'adminPart' => ROOT_PATH.'/actions/admin/_parts',
    'template' => ROOT_PATH.'/templates/'.TEMPLATE,
    'templatePart' => ROOT_PATH.'/templates/'.TEMPLATE.'/_parts',
];

require __DIR__.'/routing.php';

GC\Logger::response(sprintf('%s :: ExecutionTime: %s',
    http_response_code(),
    (microtime(true) - START_TIME)
));
