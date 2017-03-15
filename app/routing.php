<?php

/** Plik ładuje odpowiednią akcję poprzez warunki routingu */

$slug = $request->slug;
$method = $request->method;
$parts = explode('/', trim($request->slug, '/'));

$_PARAMETERS = array_filter($parts, 'ctype_digit');
$_SEGMENTS = array_filter($parts, function ($segment) {
    return !ctype_digit($segment);
});

$findRoutingFile = function ($path, $name) use ($method) {
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
            logger('[ROUTING] '.relativePath($file));

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

$getTemplateFile = function ($name, $theme = 'default') use ($method) {
    $files = [
        TEMPLATE_PATH."/{$method}-{$name}-{$theme}.html.php",
        TEMPLATE_PATH."/{$name}-{$theme}.html.php",
        TEMPLATE_PATH."/{$method}-{$name}.html.php",
        TEMPLATE_PATH."/{$name}.html.php",
    ];

    foreach ($files as $file) {
        if (file_exists($file)) {
            logger("[FRONTEND] ".relativePath($file));

            return $file;
        }
    }

    return null;
};

# jeżeli istnieje statyczna strona główna
if ($slug === '/' and $file = $getTemplateFile('static/homepage')) {
    return require $file;
}

# jeżeli istnieje statyczna strona o takim samym slugu
if ($file = $getTemplateFile("static{$slug}")) {
    return require $file;
}

# pobierz rusztowanie po slugu
$frame = GC\Model\Frame::select()
    ->equals('slug', $slug)
    ->fetch();

# jeżeli nie uda się pobrać rusztowania
if (!$frame) {
    return displayError(404);
}

# jeżeli istnieje niestandardowy plik w folderze z szablonem
if ($file = $getTemplateFile("custom/".$frame['frame_id'], $frame['theme'])) {
    return require $file;
}

# jeżeli slug rusztowania wskazuje na stronę główną
if ($frame['slug'] == '/' and $file = $getTemplateFile('homepage', $frame['theme'])) {
    return require $file;
}

# jeżeli istnieje plik rusztowania w folderze z szablonem
if ($file = $getTemplateFile("frames/".$frame['type'], $frame['theme'])) {
    return require $file;
}
