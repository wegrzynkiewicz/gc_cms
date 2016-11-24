<?php

/* Ładowanie odpowiednią akcję */

$request = '/'.trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$requestQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
$rootUri = dirname($_SERVER['SCRIPT_NAME']);
$method = strtoupper($_SERVER['REQUEST_METHOD']);

logger("[REQUEST] $method $request", $_REQUEST);

# jeżeli aplikacja jest zainstalowana w katalogu, wtedy pomiń adres katalogu i dodaj prefiks dla adresów
if ($rootUri and strpos($request, $rootUri) === 0) {
    $request = substr($request, strlen($rootUri));
    define('ROOT_URL', $rootUri);
} else {
    define('ROOT_URL', '');
}

# jeżeli adres zawiera front controller, wtedy go usuń i dodaj prefiks dla adresów
$frontController = '/index.php';
if (strpos($request, $frontController) === 0) {
    $request = substr($request, strlen($frontController));
    define('FRONT_CONTROLLER_URL', $frontController);
} else {
    define('FRONT_CONTROLLER_URL', '');
}

# jeżeli adres bez ścieżki wtedy załaduj akcję główną
if (empty(trim($request, '/'))) {
    logger("[ROUTING] Homepage");
    return require_once ACTIONS_PATH.'/frontend/homepage.php';
}

$_SEGMENTS = explode('/', trim($request, '/'));

# sprawdza pierwszy segment w adresie czy nie jest jednym z dostępnych języków
if (strlen($_SEGMENTS[0]) == 2) {
    foreach(array_keys($config['langs']) as $lang) {
        if ($_SEGMENTS[0] == $lang) {
            $config['gen']['lang'] = $lang;
            array_shift($_SEGMENTS);
            break;
        }
    }
}

# jeżeli jedyny segment okazał się być językowym prefiksem wtedy do głowej
if (count($_SEGMENTS) === 0) {
    logger("[ROUTING] Homepage");
    return require_once ACTIONS_PATH.'/frontend/homepage.php';
}

# jeżeli któryś z niestandardowych rewritów okaże się pasować, wtedy przekieruj na właściwy adres
$fullRequest = "$request?$requestQuery";
foreach ($config['rewrites'] as $pattern => $destination) {
    if (preg_match($pattern, $fullRequest)) {
        $result = preg_replace($pattern, $destination, $fullRequest);
        logger("[ROUTING] Custom rewrite :: $result", [$fullRequest, $pattern, $destination]);
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
        logger("[ROUTING] Nested :: $file");
        return require_once $file;
    }

    if (!is_dir($path)) {
        break;
    }
}

# jeżeli nie istnieje akcja to spróbuj załadować plik start w katalogu końcowym
$file = $path.'/start.php';
if (file_exists($file)) {
    logger("[ROUTING] Start :: $file");
    return require_once $file;
}

# następuje analiza sluga adresu, aby uruchomić odpowiednią akcję
$slug = array_shift($_SEGMENTS);
$absoluteSlug = '/'.implode('/', $_SEGMENTS);
$frameTypes = array_keys($config['frames']);

# najpierw sprawdzamy czy adres nie zaczyna się od np. /product, /article
if (in_array($slug, $frameTypes)) {
    logger("[ROUTING] Frame :: $slug");
    return require_once ACTIONS_PATH."/frontend/frames/$slug.php";
}

# jeżeli istnieje niestandardowy plik w folderze z szablonem
$customFile = TEMPLATE_PATH."/custom/$slug.html.php";
if (file_exists($customFile)) {
    logger("[ROUTING] Custom slug :: $slug");
    return require_once $customFile;
}

# jeżeli nie istnieje ostatni parametr wtedy zamień sluga na id strony
$id = intval(count($_SEGMENTS) === 0 ? $slug : array_shift($_SEGMENTS));

# jeżeli ostatni parametr nie jest prawidłową liczbą
if ($id <= 0) {
    logger("[ROUTING] Error :: 404");
    return require_once TEMPLATE_PATH."/errors/404.html.php";
}

# jeżeli istnieje niestandardowy plik w folderze z szablonem
$customFile = TEMPLATE_PATH."/custom/$id.html.php";
if (file_exists($customFile)) {
    logger("[ROUTING] Custom id :: $customFile");
    return require_once $customFile;
}

# jeżeli istnieje strona w systemie o zadanym id
$page = $pageModel->selectWithFrameByPrimaryId($id);
if ($page) {
    logger("[ROUTING] Page :: $id", $page);
    return require_once ACTIONS_PATH."/frontend/frames/page.php";
}

# jeżeli cały adres znalazł się w tablicy przekierowań
/*$page = $slugModel->selectWithFrameByPrimaryId($absoluteSlug);
if ($page) {
    return require_once ACTIONS_PATH."/frontend/frames/page.php";
}*/

# jeżeli żaden plik nie pasuje, wtedy wyświetl błąd 404
logger("[ROUTING] Endpoint error 404");
return require_once TEMPLATE_PATH."/errors/404.html.php";
