<?php

if ($config['debug']['enabled']) {
    $query = http_build_query([
        'db' => $config['database']['name'],
        'server' => $config['database']['host'],
        'username' => $config['database']['username'],
    ]);
    redirect("/vendor/vrana/adminer/adminer/index.php?{$query}");
}
