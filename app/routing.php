<?php

/** Plik ładuje odpowiednią akcję poprzez warunki routingu */

$path = $request->path;

# jeżeli adres bez ścieżki wtedy załaduj akcję główną
if (empty(trim($path, '/'))) {
    GC\Logger::routing("Homepage");

    return require ACTIONS_PATH.'/homepage.php';
}

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

# jeżeli jedyny segment okazał się być językowym prefiksem wtedy do głowej
if (count($_SEGMENTS) === 0) {
    GC\Logger::routing("Homepage with lang");

    return require ACTIONS_PATH."/homepage-{$request->method}.php";
}

# jeżeli któryś z niestandardowych rewritów okaże się pasować, wtedy przekieruj na właściwy adres
$fullRequest = rtrim("{$path}?{$request->query}", '?');
foreach ($config['rewrites'] as $pattern => $destination) {
    if (preg_match($pattern, $fullRequest)) {
        $result = preg_replace($pattern, $destination, $fullRequest);
        GC\Logger::routing("Custom rewrite :: $result", [$fullRequest, $pattern, $destination]);
        GC\Response::redirect($result, 301); # 301 Moved Permanently
    }
}

# wyszukaj plik w katalogu /actions, który pasuje do adresu url
$path = ACTIONS_PATH;
$copySegments = $_SEGMENTS;
while (count($_SEGMENTS) > 0) {
    $segment = array_shift($_SEGMENTS);

    # jeżeli istnieje plik "import" to załaduj, ale nie kończ pętli
    $file = "{$path}/{$segment}/_import.php";
    if (file_exists($file)) {
        GC\Logger::import(relativePath($file));
        require $file;
    }

    # jeżeli istnieje plik z metodą requesta na początku, załaduj
    $file = "{$path}/{$segment}-{$request->method}.php";
    if (file_exists($file)) {
        GC\Logger::routing("Nested with method :: ".relativePath($file));

        return require $file;
    }

    # jeżeli istnieje plik, wtedy załaduj
    $file = "{$path}/{$segment}.php";
    if (file_exists($file)) {
        GC\Logger::routing("Nested :: ".relativePath($file));

        return require $file;
    }

    # jeżeli istnieje folder, wtedy kontynuuj pętlę, ale nie wykonuj dalej
    $folder = "{$path}/{$segment}";
    if (is_dir($folder) and !empty($_SEGMENTS)) {
        $path = $folder;
        continue;
    }

    # jeżeli nie istnieje akcja to spróbuj załadować plik start
    $file = "{$path}/{$segment}/start.php";
    if (file_exists($file)) {
        GC\Logger::routing("Start :: ".relativePath($file));

        return require $file;
    }

    $path = $folder;
}

$_SEGMENTS = $copySegments;

# następuje analiza sluga adresu, aby uruchomić odpowiednią akcję
$slug = array_shift($_SEGMENTS);
$absoluteSlug = '/'.implode('/', $_SEGMENTS);

# jeżeli istnieje niestandardowy plik w folderze z szablonem
$customFile = TEMPLATE_PATH."/custom/{$slug}.html.php";
if (file_exists($customFile)) {
    GC\Logger::routing("Custom slug :: ".relativePath($customFile));

    return require $customFile;
}

# jeżeli nie istnieje ostatni parametr wtedy zamień sluga na id strony
$id = intval(count($_SEGMENTS) === 0 ? $slug : array_shift($_SEGMENTS));

# jeżeli ostatni parametr nie jest prawidłową liczbą
if ($id <= 0) {
    GC\Logger::routing("Error invalid ID :: 404");

    return require TEMPLATE_PATH.'/errors/404.html.php';
}

# jeżeli istnieje niestandardowy plik w folderze z szablonem
$customFile = TEMPLATE_PATH."/custom/{$id}.html.php";
if (file_exists($customFile)) {
    GC\Logger::routing("Custom id :: ".relativePath($customFile));

    return require $customFile;
}

# jeżeli żaden plik nie pasuje, wtedy wyświetl błąd 404
GC\Logger::routing("Endpoint error 404");

return require TEMPLATE_PATH.'/errors/404.html.php';
