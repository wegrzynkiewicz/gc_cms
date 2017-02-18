<?php

/** Plik wyszukuje traz poddawanych translacji i zapisuje je do pliku **/

require_once __DIR__.'/../app/bootstrap.php';

$domains = [
    'admin' => ACTIONS_PATH.'/admin',
    'auth' => ACTIONS_PATH.'/auth',
    'template-'.TEMPLATE => TEMPLATE_PATH,
];
$translations = [];

foreach ($domains as $domain => $path) {
    $files = globRecursive($path.'/*.php');
    foreach ($files as $file) {
        $content = file_get_contents($file);
        preg_match_all('~trans\([\'"](.*?)[\'"].*?\)~', $content, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $translations[$domain][$match[1]] = $match[1];
        }
    }
}

$json = json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$file = TEMP_PATH.'/translations-dump.json';
file_put_contents($file, $json);
