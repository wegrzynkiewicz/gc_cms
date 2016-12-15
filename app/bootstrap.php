<?php

/* Bootstapuje aplikację */

define('START_TIME', microtime(true));

session_start();

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = [];
}

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/config/config.php';
require_once __DIR__.'/functions.php';
require_once __DIR__.'/error-handler.php';

header_remove("X-Powered-By");
setHeaderMimeType('text/html');
date_default_timezone_set($config['timezone']);

if ($config["debug"]) {
    error_reporting(E_ALL ^ E_STRICT);
    ini_set('display_errors', 'on');
}


GC\Storage\Database::$pdo = new PDO($config["db"]["dns"], $config["db"]["username"], $config["db"]["password"]);
GC\Storage\Database::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
GC\Storage\Database::$prefix = $config["db"]["prefix"];

require_once __DIR__.'/routing.php';

# przydatna wartość jeżeli potrzeba wrócić z gęstwiny przekierować
$_SESSION['preview_url'] = $request;

GC\Logger::response(sprintf("%s :: ExecutionTime: %s",
    http_response_code(),
    (microtime(true) - START_TIME)
));

GC\Logger::response(print_r(get_included_files(), true));
