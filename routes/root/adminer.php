<?php

if ($config['debug']['enabled']) {
    $query = http_build_query([
        'db' => $config['database']['name'],
        'server' => $config['database']['host'],
        'username' => $config['database']['username'],
    ]);
    absoluteRedirect("/vendor/vrana/adminer/adminer/index.php?{$query}");
}
