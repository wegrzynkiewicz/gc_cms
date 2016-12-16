<?php

/* Bootstapuje aplikację */

define('START_TIME', microtime(true));

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/config/config.php';
require_once __DIR__.'/functions.php';
require_once __DIR__.'/error-handler.php';

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
    error_reporting(E_ALL ^ E_STRICT);
    ini_set('display_errors', 'on');
}

GC\Storage\Database::$pdo = new PDO($config['db']['dns'], $config['db']['username'], $config['db']['password']);
GC\Storage\Database::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
GC\Storage\Database::$prefix = $config['db']['prefix'];

require_once __DIR__.'/routing.php';

GC\Logger::response(sprintf('%s :: ExecutionTime: %s',
    http_response_code(),
    (microtime(true) - START_TIME)
));

GC\Logger::response(print_r(get_included_files(), true));
