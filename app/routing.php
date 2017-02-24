<?php

/** Plik ładuje odpowiednią akcję poprzez warunki routingu */

$slug = trim($request->slug, '/');
$method = $request->method;
$parts = explode('/', $slug);

$_PARAMETERS = array_filter($parts, 'ctype_digit');
$_SEGMENTS = array_filter($parts, function ($segment) {
    return !ctype_digit($segment);
});

$findRoutingFile = function ($path, $name) use ($method)
{
    $files = [
        "{$path}/{$method}-{$name}.html.php",
        "{$path}/{$method}-{$name}.json.php",
        "{$path}/{$method}-{$name}.php",
        "{$path}/{$name}.html.php",
        "{$path}/{$name}.json.php",
        "{$path}/{$name}.php",
    ];

    foreach ($files as $file) {
        if (file_exists($file)) {
            logger('[ROUTING]'.relativePath($file));

            return $file;
        }
    }

    return null;
};

# wyszukaj plik w katalogu akcji, który pasuje do adresu uri
$path = ROUTES_PATH;
while (count($_SEGMENTS) > 0) {
    $segment = array_shift($_SEGMENTS);

    # jeżeli istnieje jakikolwiek z pasujących plików
    if ($file = $findRoutingFile($path, $segment)) {
        return require $file;
    }

    # jeżeli istnieje folder, wtedy kontynuuj pętlę, ale nie wykonuj dalej
    $folder = "{$path}/{$segment}";
    if (is_dir($folder) and count($_SEGMENTS)) {
        $path = $folder;
        continue;
    }

    # jeżeli nie istnieje akcja to spróbuj załadować plik start
    if ($file = $findRoutingFile("{$path}/{$segment}", 'start')) {
        return require $file;
    }

    break;
}

unset($_SEGMENTS);
unset($_PARAMETERS);

return require __DIR__.'/frontend.php';
