<?php

/** Zawiera szereg rutynowych zadań podczas instalowania bazy danych **/

require_once __DIR__.'/../app/bootstrap.php';

if (is_dir())

require __DIR__.'/translations-dump.php';

$json = file_get_contents(TEMP_PATH.'/translations-dump.json');
foreach ($config['langs'] as $code => $lang) {
    $path = $config['translator']['folder']."/{$code}.json";
    file_put_contents($path, $json);
}

rename(__FILE__, '!'.__FILE__);
