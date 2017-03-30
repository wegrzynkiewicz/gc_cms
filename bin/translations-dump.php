<?php

/** Plik wyszukuje traz poddawanych translacji i zapisuje je do pliku **/

require_once __DIR__.'/../app/bootstrap.php';

echo PHP_EOL;
echo "Dumping translations...".PHP_EOL;

$domains = [
    'admin' => [
        ROUTES_PATH."/admin",
        ROUTES_PATH."/root",
        ROOT_PATH.'/app/etc',
    ],
    'auth' => [
        ROUTES_PATH."/auth",
    ],
    'template-'.TEMPLATE => [
        TEMPLATE_PATH,
    ],
];
$translations = [];

foreach ($domains as $domain => $paths) {
    foreach ($paths as $path) {
        $files = globRecursive($path.'/*.php');
        foreach ($files as $file) {
            $content = file_get_contents($file);
            preg_match_all('~trans\([\'"](.*?)[\'"].*?\)~', $content, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $translations[$domain][$match[1]] = $match[1];
            }
        }
    }
}

$json = json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$file = TEMP_PATH.'/translations-dump.json';

echo "Creating file: {$file}".PHP_EOL;
makeDirRecursive(dirname($file));
file_put_contents($file, $json);

echo 'Translations dumped.'.PHP_EOL;
