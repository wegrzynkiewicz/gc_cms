<?php

$files = array_filter(rglob('*.*'), function ($value) {
    return in_array(pathinfo($value, PATHINFO_EXTENSION), [
        'php', 'js', 'css', 'json', 'txt', 'md', 'html'
    ]);
});

$hashes = [];
foreach($files as $file) {
    $hashes[trim($file, '.')] = sha1(file_get_contents($file));
}

$json = json_encode($hashes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
file_put_contents(ROOT_PATH.'/app/storage/checksum.json', $json);
