<?php

/** Plik ładuje odpowiednią akcję poprzez warunki routingu */

$requestUri = trim($request->uri, '/');
$parts = explode('/', $requestUri);

$_PARAMETERS = array_filter($parts, 'ctype_digit');
$_SEGMENTS = array_filter($parts, function ($segment) {
    return !ctype_digit($segment);
});

# wyszukaj plik w katalogu /actions, który pasuje do adresu uri
$path = ACTIONS_PATH;
while (count($_SEGMENTS) > 0) {
    $segment = array_shift($_SEGMENTS);

    # jeżeli istnieje plik z metodą requesta na początku, załaduj
    $file = "{$path}/{$segment}-{$request->method}.php";
    if (file_exists($file)) {
        $logger->info("[ROUTING] Nested with method {$file}");
        return require $file;
    }

    # jeżeli istnieje plik, wtedy załaduj
    $file = "{$path}/{$segment}.php";
    if (file_exists($file)) {
        $logger->info("[ROUTING] Nested without method {$file}");
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
        $logger->info("[ROUTING] Start {$file}");
        return require $file;
    }

    break;
}

unset($_SEGMENTS);
unset($_PARAMETERS);

return require __DIR__.'/frontend.php';
