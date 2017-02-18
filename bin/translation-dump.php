<?php

require __DIR__.'/../app/bootstrap.php';

$domains = [
    'admin' => ACTIONS_PATH.'/admin',
    'auth' => ACTIONS_PATH.'/auth',
    'template' => TEMPLATE_PATH,
];

globRecursive();
