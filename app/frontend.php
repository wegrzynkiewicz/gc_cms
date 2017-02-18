<?php

/** Stara się pobrać odpowiednie rusztowanie */

$slug = $request->uri;
$lang = GC\Visitor::getLang();
$method = $request->method;

$getTemplateFile = function ($name, $theme = 'default') use ($lang, $method)
{
    $files = [
        TEMPLATE_PATH."/{$name}-{$theme}-{$lang}-{$method}.html.php",
        TEMPLATE_PATH."/{$name}-{$theme}-{$method}.html.php",
        TEMPLATE_PATH."/{$name}-{$theme}-{$lang}.html.php",
        TEMPLATE_PATH."/{$name}-{$theme}.html.php",
        TEMPLATE_PATH."/{$name}-{$lang}-{$method}.html.php",
        TEMPLATE_PATH."/{$name}-{$method}.html.php",
        TEMPLATE_PATH."/{$name}-{$lang}.html.php",
        TEMPLATE_PATH."/{$name}.html.php",
    ];

    foreach ($files as $file) {
        if (file_exists($file)) {
            return $file;
        }
    }

    return null;
};

# jeżeli istnieje statyczna strona główna
if ($slug === '/' and $file = $getTemplateFile('static/homepage')) {
    $logger->info('[FRONTEND] Static homepage');
    return require $file;
}

# jeżeli istnieje statyczna strona o takim samym slugu
if ($file = $getTemplateFile("static{$slug}")) {
    $logger->info("[FRONTEND] Static {$file}");
    return require $file;
}

# pobierz rusztowanie po slugu
$frame = GC\Model\Frame::select()
    ->equals('slug', $slug)
    ->fetch();

# jeżeli nie uda się pobrać rusztowania
if (!$frame) {
    $logger->info('[FRONTEND] Frame does not exists 404');
    return require TEMPLATE_PATH.'/errors/404.html.php';
}

$frame_id = $frame['frame_id'];
$frame_type = $frame['type'];
$theme = $frame['theme'];

# jeżeli istnieje niestandardowy plik w folderze z szablonem
if ($file = $getTemplateFile("custom/{$frame_id}", $theme)) {
    $logger->info("[FRONTEND] Custom {$file}");
    return require $file;
}

# jeżeli slug rusztowania wskazuje na stronę główną
if ($frame['slug'] == '/' and $file = $getTemplateFile('homepage', $theme)) {
    $logger->info("[FRONTEND] Homepage {$file}");
    return require $file;
}

# jeżeli istnieje plik rusztowania w folderze z szablonem
$file = TEMPLATE_PATH."/frames/{$frame_type}.html.php";
if ($file = $getTemplateFile("frames/{$frame_type}", $theme)) {
    $logger->info("[FRONTEND] Frame {$frame_type} {$file}");
    return require $file;
}

$widgets = GC\Model\Widget::select()
    ->equals('lang', GC\Visitor::getLang())
    ->fetchByKey('workname');
