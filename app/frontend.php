<?php

/** Stara się pobrać odpowiednie rusztowanie */

$slug = $request->slug;
$method = $request->method;

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
