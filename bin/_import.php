<?php

require_once __DIR__.'/../app/bootstrap.php';

$areYouSure = function ()
{
    echo "Are you sure you want to do this? Type 'yes' to continue: ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    if (trim($line) != 'yes') {
        echo "ABORTING!!".PHP_EOL;
        exit;
    }
    fclose($handle);
};

$inputValue = function ($message)
{
    echo $message;
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    $line = trim($line);
    fclose($handle);

    return $line;
};

echo 'GrafCenterCMF '.GCCMF_VERSION.' made with <3 by @wegrzynkiewicz for @grafcenter'.PHP_EOL;
