<?php

/* Bootstapuje aplikację */

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/functions.php';

# załadowanie pliku konfiguracyjnego
$config = require __DIR__.'/config/config.php';
GC\Data::set('config', $config);

# serwis logowania do pliku, jeżeli logowanie wyłączone wtedy utwórz atrapę
$logger = $config['logger']['enabled']
    ? new GC\Debug\FileLogger($config['logger']['folder'].'/'.date('Y-m-d').'.log')
    : new GC\Debug\NullLogger();
GC\Data::set('logger', $logger);

# serwis do łatwego tłumaczenia tekstu: $trans('text')
$trans = function ($text, array $params = []) {
    return GC\Data::get('translator')->translate($text, $params);
};
GC\Data::set('trans', $trans);

# serwis translacji tekstu, jeżeli translacja wyłączona wtedy utwórz atrapę
GC\Data::registerLazyService('translator', function () use (&$config) {
    return $config['translator']['enabled']
        ? new GC\Translation\FileTranslator($config['translator']['folder'].'/'.GC\Auth\Client::getLang().'.json')
        : new GC\Translation\NullTranslator();
});

# serwis bazodanowy, łączy się z bazą tylko jeżeli jest to potrzebne
GC\Data::registerLazyService('database', function () use (&$config, &$logger) {
    $dbConfig = &$config['database'];
    $pdo = new \PDO(
        $dbConfig['dns'],
        $dbConfig['username'],
        $dbConfig['password']
    );
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $database = new GC\Storage\Database($pdo);
    $database->prefix = $dbConfig['prefix'];

    $logger->database($dbConfig['dns']);

    return $database;
});

# serwis pomocniczy do tworzenia nawigacji
GC\Data::registerLazyService('breadcrumbs', function () {
    return new GC\Breadcrumbs();
});

# pobranie najważniejszych danych o adresie strony
$seoConfig = &$config['seo'];
$httpHost = server('HTTP_HOST', 'localhost');
$protocol = 'http'.(stripos(server('SERVER_PROTOCOL', 'http'), 'https') === true ? 's' : '');
$www = substr($httpHost, 0, 4) === 'www.' ? 'www.' : '';
$domain = server('SERVER_NAME', $httpHost);
$uri = rtrim(server('REQUEST_URI'), '/');
$port = intval(server('SERVER_PORT', 80));
$currentUrl = $protocol.'://'.$httpHost.$uri;

# sprawdzenie czy adres który wpisał odbiorca zgadza się z polityką seo
if ($seoConfig['forceHTTPS'] !== null) {
    $protocol = 'http'.((bool)$seoConfig['forceHTTPS'] ? 's' : '');
}

if ($seoConfig['forceWWW'] !== null) {
    $www = (bool)$seoConfig['forceWWW'] ? 'www.' : '';
}

if ($seoConfig['forceDomain'] !== null  and $domain !== $seoConfig['forceDomain']) {
    $domain = $seoConfig['forceDomain'];
}

if ($seoConfig['forcePort'] !== null and $port !== $seoConfig['forcePort']) {
    $port = intval($seoConfig['forcePort']);
}

$targetPort = $port === 80 ? '' : ":{$port}";
$targetUrl = $protocol.'://'.$www.$domain.$targetPort.$uri;

# przekierowanie na docelowy adres, pomocne przy seo
if ($currentUrl !== $targetUrl) {
    $logger->seo("From: {$currentUrl} To: {$targetUrl}");
    GC\Response::redirect($targetUrl, 301);  # 301 Moved Permanently
}

# serwis reprezentujący żądanie
$request = new GC\Request();
GC\Data::set('request', $request);

# jeżeli któryś z niestandardowych rewritów okaże się pasować, wtedy przekieruj na właściwy adres
$fullRequest = rtrim("{$request->path}?{$request->query}", '?');
foreach ($config['rewrites'] as $pattern => $destination) {
    if (preg_match($pattern, $fullRequest)) {
        $result = preg_replace($pattern, $destination, $fullRequest);
        GC\Response::redirect($result, 301); # 301 Moved Permanently
    }
}

session_start();

# sprawdzana jest weryfikacja csrf tokenu, chroni przed spreparowanymi żądaniami
// if (!$request->isMethod('GET') and isset($_SESSION['csrf_token'])) {
//     if (isset($_SERVER['HTTP_X_CSRFTOKEN']) && $_SERVER['HTTP_X_CSRFTOKEN'] === $_SESSION['csrf_token']) {
//         GC\Data::get('logger')->csrf("Token verified via header");
//     } elseif (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
//         GC\Data::get('logger')->csrf("Token verified via request");
//     } else {
//         GC\Data::get('logger')->csrf("Invalid token");
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

# serwis zwraca odpowiedni plik do uruchomienia
$routing = function (&$importFiles) use (&$config, &$logger, &$request) {

    $path = $request->path; # zawiera ścieżkę żądania
    $_SEGMENTS = explode('/', trim($path, '/'));

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

    # jeżeli adres bez ścieżki wtedy załaduj akcję główną
    if (empty(trim($path, '/'))) {
        return ACTIONS_PATH.'/homepage.php';
    }

    # jeżeli strona jest w budowie wtedy zwróć komunikat o budowie, chyba, że masz uprawnienie
    if ($config['debug']['inConstruction']) {
        if (isset($_REQUEST['you-shall-not-pass'])) {
            $_SESSION['allowInConstruction'] = true;
        }
        if (!isset($_SESSION['allowInConstruction'])) {
            return TEMPLATE_PATH.'/errors/construction.html.php';
        }
    }

    # jeżeli jedyny segment okazał się być językowym prefiksem wtedy do głowej
    if (count($_SEGMENTS) === 0) {
        return ACTIONS_PATH."/homepage-{$request->method}.php";
    }

    # wyszukaj plik w katalogu /actions, który pasuje do adresu url
    $path = ACTIONS_PATH;
    $_PARAMETERS = [];
    $copySegments = $_SEGMENTS;
    while (count($_SEGMENTS) > 0) {
        $segment = array_shift($_SEGMENTS);

        # jeżeli istnieje plik "import" to załaduj, ale nie kończ pętli
        $file = "{$path}/{$segment}/_import.php";
        if (file_exists($file)) {
            $importFiles[] = $file;
        }

        # jeżeli istnieje plik z metodą requesta na początku, załaduj
        $file = "{$path}/{$segment}-{$request->method}.php";
        if (file_exists($file)) {
            return $file;
        }

        # jeżeli istnieje plik, wtedy załaduj
        $file = "{$path}/{$segment}.php";
        if (file_exists($file)) {
            return $file;
        }

        # jeżeli istnieje folder, wtedy kontynuuj pętlę, ale nie wykonuj dalej
        $folder = "{$path}/{$segment}";
        if (is_dir($folder) and count($_SEGMENTS)) {
            $path = $folder;
            continue;
        }

        # jeżeli nie istnieje akcja to spróbuj załadować plik start
        $file = "{$path}/{$segment}/start.php";
        if (file_exists($file)) {
            return $file;
        }

        $_PARAMETERS[] = $segment;
    }

    $_SEGMENTS = $copySegments;

    # następuje analiza sluga adresu, aby uruchomić odpowiednią akcję
    $slug = array_shift($_SEGMENTS);
    $absoluteSlug = '/'.implode('/', $_SEGMENTS);

    # jeżeli istnieje niestandardowy plik w folderze z szablonem
    $customFile = TEMPLATE_PATH."/custom/{$slug}.html.php";
    if (file_exists($customFile)) {
        return $customFile;
    }

    # jeżeli nie istnieje ostatni parametr wtedy zamień sluga na id strony
    $id = intval(count($_SEGMENTS) === 0 ? $slug : array_shift($_SEGMENTS));

    # jeżeli ostatni parametr nie jest prawidłową liczbą
    if ($id <= 0) {
        return TEMPLATE_PATH.'/errors/404.html.php';
    }

    # jeżeli istnieje niestandardowy plik w folderze z szablonem
    $customFile = TEMPLATE_PATH."/custom/{$id}.html.php";
    if (file_exists($customFile)) {
        return $customFile;
    }

    # jeżeli żaden plik nie pasuje, wtedy wyświetl błąd 404
    return TEMPLATE_PATH.'/errors/404.html.php';
};

$importFiles = [];
$routedFilepath = $routing($importFiles);
foreach ($importFiles as $importFile) {
    require $importFile;
    $logger->import($importFile);
}

require $routedFilepath;

$logger->response(sprintf('%s :: Time: %ss :: Memory: %sMiB ::',
    http_response_code(),
    microtime(true) - START_TIME,
    memory_get_peak_usage(true) / 1048576
));
