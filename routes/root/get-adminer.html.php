<?php

require ROUTES_PATH."/root/_only-debug.php";
require ROUTES_PATH."/root/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/root/_breadcrumbs.php";

$query = http_build_query([
    'db' => $config['database']['name'],
    'server' => $config['database']['host'],
    'username' => $config['database']['username'],
]);
redirect("/vendor/vrana/adminer/adminer/index.php?{$query}");
