<?php

/* Bootstapuje aplikację */

define('START_TIME',    microtime(true));

session_start();

require_once __DIR__.'/config/config.php';
require_once __DIR__.'/functions.php';
require_once __DIR__.'/error-handler.php';

require_once ROOT_PATH.'/src/GrafCenter/Storage/Database.php';
require_once ROOT_PATH.'/src/GrafCenter/Storage/Database.php';

header_remove("X-Powered-By");
setHeaderMimeType('text/html');
date_default_timezone_set($config['timezone']);

if ($config["debug"]) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
}

$pdo = new PDO($config["db"]["dns"], $config["db"]["user"], $config["db"]["password"]);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

Database::$pdo    = $pdo;
Database::$prefix = $config["db"]["prefix"];

require_once __DIR__.'/routing.php';

logger(sprintf("[RESPONSE] %s :: ExecutionTime: %s",
    http_response_code(),
    (microtime(true) - START_TIME)
));
