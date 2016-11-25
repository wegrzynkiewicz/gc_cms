<?php

/* Bootstapuje aplikację */

define('START_TIME',    microtime(true));

session_start();

require_once __DIR__.'/config/config.php';
require_once __DIR__.'/functions.php';
require_once __DIR__.'/error-handler.php';

# dodaje dodatkowy autoloader do ładowania klas
spl_autoload_register(function ($class) {
    require_once __DIR__."/classes/$class.php";
});

# ładuje rekursywnie wszystkie pliki w katalogu models
foreach (rglob(__DIR__.'/models/*.php') as $file) {
    require_once $file;
}

header_remove("X-Powered-By");
setHeaderMimeType('text/html');
date_default_timezone_set($config['timezone']);

if ($config["debug"]) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
}

Database::initialize(
    new PDO(
        $config["db"]["dns"],
        $config["db"]["user"],
        $config["db"]["password"]
    ),
    $config["db"]["prefix"]
);

require_once __DIR__.'/routing.php';

logger(sprintf("[RESPONSE] %s :: ExecutionTime: %s",
    http_response_code(),
    (microtime(true) - START_TIME)
));
