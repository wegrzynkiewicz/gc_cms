<?php

/* Bootstapuje aplikację */

define('START_TIME', microtime(true));

use GCC\Storage\Database;
use GCC\Logger;

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


Database::$pdo = new PDO($config["db"]["dns"], $config["db"]["username"], $config["db"]["password"]);
Database::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
Database::$prefix = $config["db"]["prefix"];

require_once __DIR__.'/routing.php';

# przydatna wartość jeżeli potrzeba wrócić z gęstwiny przekierować
$_SESSION['preview_url'] = $request;

Logger::response(sprintf("%s :: ExecutionTime: %s",
    http_response_code(),
    (microtime(true) - START_TIME)
));

Logger::response(print_r(get_included_files(), true));
