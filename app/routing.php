<?php

/* Ładowanie odpowiednią akcję */

use GCC\Logger;

$request = '/'.trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$requestQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
$rootUrl = dirname($_SERVER['SCRIPT_NAME']);
$method = strtoupper($_SERVER['REQUEST_METHOD']);

Logger::request(sprintf("%s %s", $method, trim("$request?$requestQuery", '?')), $_REQUEST);

# jeżeli aplikacja jest zainstalowana w katalogu, wtedy pomiń adres katalogu
if ($rootUrl and strpos($request, $rootUrl) === 0) {
    $request = substr($request, strlen($rootUrl));
    define('ROOT_URL', $rootUrl);
} else {
    define('ROOT_URL', '');
}

# jeżeli adres zawiera front controller, wtedy go usuń
$frontController = '/index.php';
if (strpos($request, $frontController) === 0) {
    $request = substr($request, strlen($frontController));
    define('FRONT_CONTROLLER_URL', $frontController);
} else {
    define('FRONT_CONTROLLER_URL', '');
}

# jeżeli adres bez ścieżki wtedy załaduj akcję główną
if (empty(trim($request, '/'))) {
    Logger::routing("Homepage");

    return require_once ACTIONS_PATH.'/homepage.php';
}

$_SEGMENTS = explode('/', trim($request, '/'));

# sprawdza pierwszy segment w adresie czy nie jest jednym z dostępnych języków
unset($_SESSION['lang']['routing']);
if (strlen($_SEGMENTS[0]) == 2) {
    foreach (array_keys($config['langs']) as $lang) {
        if ($_SEGMENTS[0] == $lang) {
            $_SESSION['lang']['routing'] = $lang;
            array_shift($_SEGMENTS);
            break;
        }
    }
}

# jeżeli jedyny segment okazał się być językowym prefiksem wtedy do głowej
if (count($_SEGMENTS) === 0) {
    Logger::routing("Homepage with lang");

    return require_once ACTIONS_PATH.'/homepage.php';
}

# jeżeli któryś z niestandardowych rewritów okaże się pasować, wtedy przekieruj na właściwy adres
$fullRequest = rtrim("$request?$requestQuery", '?');
foreach ($config['rewrites'] as $pattern => $destination) {
    if (preg_match($pattern, $fullRequest)) {
        $result = preg_replace($pattern, $destination, $fullRequest);
        Logger::routing("Custom rewrite :: $result", [$fullRequest, $pattern, $destination]);
        redirect($result, 301); # 301 Moved Permanently
    }
}

# wyszukaj plik w katalogu /actions, który pasuje do adresu url
$path = ACTIONS_PATH;
$segments = $_SEGMENTS;
while (count($segments) > 0) {
    $segment = array_shift($segments);
    $path .= '/'.$segment;
    $file = $path.'.php';

    if (file_exists($file)) {
        $_SEGMENTS = $segments;
        Logger::routing("Nested :: ".relativePath($file));

        return require_once $file;
    }

    # jeżeli istnieje plik "import" to załaduj, ale nie kończ pętli
    $file = $path.'/_import.php';
    if (file_exists($file)) {
        $_SEGMENTS = $segments;
        Logger::import(relativePath($file));
        require_once $file;
    }

    if (!is_dir($path)) {
        break;
    }
}

# jeżeli nie istnieje akcja to spróbuj załadować plik start w katalogu końcowym
$file = $path.'/start.php';
if (file_exists($file)) {
    Logger::routing("Start :: ".relativePath($file));

    return require_once $file;
}

# następuje analiza sluga adresu, aby uruchomić odpowiednią akcję
$slug = array_shift($_SEGMENTS);
$absoluteSlug = '/'.implode('/', $_SEGMENTS);

# jeżeli istnieje niestandardowy plik w folderze z szablonem
$customFile = TEMPLATE_PATH."/custom/$slug.html.php";
if (file_exists($customFile)) {
    Logger::routing("Custom slug :: ".relativePath($customFile));

    return require_once $customFile;
}

# jeżeli nie istnieje ostatni parametr wtedy zamień sluga na id strony
$id = intval(count($_SEGMENTS) === 0 ? $slug : array_shift($_SEGMENTS));

# jeżeli ostatni parametr nie jest prawidłową liczbą
if ($id <= 0) {
    Logger::routing("Error invalid ID :: 404");

    return require_once TEMPLATE_PATH."/errors/404.html.php";
}

# jeżeli istnieje niestandardowy plik w folderze z szablonem
$customFile = TEMPLATE_PATH."/custom/$id.html.php";
if (file_exists($customFile)) {
    Logger::routing("Custom id :: ".relativePath($customFile));

    return require_once $customFile;
}

# jeżeli istnieje strona w systemie o zadanym id
$page = Page::selectWithFrameByPrimaryId($id);
if ($page) {
    Logger::routing("Page :: $id", $page);

    return require_once ACTIONS_PATH."/page.php";
}

# jeżeli cały adres znalazł się w tablicy przekierowań
/*$page = $slugModel->selectWithFrameByPrimaryId($absoluteSlug);
if ($page) {
    return require_once ACTIONS_PATH."/frontend/frames/page.php";
}*/

# jeżeli żaden plik nie pasuje, wtedy wyświetl błąd 404
Logger::routing("Endpoint error 404");

return require_once TEMPLATE_PATH."/errors/404.html.php";
