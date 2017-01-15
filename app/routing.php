<?php

/** Plik ładuje odpowiednią akcję poprzez warunki routingu */

$url = trim($request->url, '/');

$_PARAMETERS = [];
$_SEGMENTS = explode('/', $url);

# jeżeli adres bez ścieżki wtedy załaduj akcję główną
if (empty($url)) {
    $logger->routing('Homepage');
    return require ACTIONS_PATH.'/homepage.php';
}

# sprawdza pierwszy segment w adresie czy nie jest jednym z dostępnych języków
$lang = $_SEGMENTS[0];
if (GC\Validate::installedLang($lang)) {
    GC\Visitor::$langRequest = $lang;
    array_shift($_SEGMENTS);
}

# jeżeli jedyny segment okazał się być językowym prefiksem wtedy do głowej
if (count($_SEGMENTS) === 0) {
    $logger->routing('Homepage with lang');
    return require ACTIONS_PATH."/homepage.php";
}

# wyszukaj plik w katalogu /actions, który pasuje do adresu url
$path = ACTIONS_PATH;
$copySegments = $_SEGMENTS;
while (count($_SEGMENTS) > 0) {
    $segment = array_shift($_SEGMENTS);

    # jeżeli istnieje plik "import" to załaduj, ale nie kończ pętli
    $file = "{$path}/{$segment}/_import.php";
    if (file_exists($file)) {
        $logger->import($file);
        require $file;
    }

    # jeżeli istnieje plik z metodą requesta na początku, załaduj
    $file = "{$path}/{$segment}-{$request->method}.php";
    if (file_exists($file)) {
        $logger->routing("Nested with method :: {$file}");
        return require $file;
    }

    # jeżeli istnieje plik, wtedy załaduj
    $file = "{$path}/{$segment}.php";
    if (file_exists($file)) {
        $logger->routing("Nested without method :: {$file}");
        return require $file;
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
        $logger->routing("Start :: {$file}");
        return require $file;
    }

    $_PARAMETERS[] = $segment;
}

$_SEGMENTS = $copySegments;

# następuje analiza sluga adresu, aby uruchomić odpowiednią akcję
$slug = array_shift($_SEGMENTS);
$absoluteSlug = '/'.implode('/', $_SEGMENTS);

# jeżeli istnieje niestandardowy plik w folderze z szablonem
$file = TEMPLATE_PATH."/custom/{$slug}.html.php";
if (file_exists($file)) {
    $logger->routing("Custom slug :: {$file}");
    return require $file;
}

# jeżeli nie istnieje ostatni parametr wtedy zamień sluga na id strony
$id = intval(count($_SEGMENTS) === 0 ? $slug : array_shift($_SEGMENTS));

# jeżeli ostatni parametr nie jest prawidłową liczbą
if ($id <= 0) {
    $logger->routing('Invalid parameter ID');
    return require TEMPLATE_PATH.'/errors/404.html.php';
}

# jeżeli istnieje niestandardowy plik w folderze z szablonem
$file = TEMPLATE_PATH."/custom/{$id}.html.php";
if (file_exists($file)) {
    $logger->routing('Custom ID');
    return require $file;
}

# jeżeli żaden plik nie pasuje, wtedy wyświetl błąd 404
$logger->routing('End point 404');
return require TEMPLATE_PATH.'/errors/404.html.php';
