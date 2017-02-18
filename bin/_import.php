<?php

require_once __DIR__.'/../app/bootstrap.php';

echo 'GrafCenterCMF '.GCCMF_VERSION.' made with <3 by @wegrzynkiewicz for @grafcenter'.PHP_EOL;

if (!$config['debug']['enabled']) {
    echo 'Command tools are avaible only in debug mode.'.PHP_EOL;
    echo 'Aborting!'.PHP_EOL;
}

$areYouSure = function ()
{
    echo "Are you sure you want to do this? Type 'yes' to continue: ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    if (trim($line) != 'yes') {
        echo 'Aborting!'.PHP_EOL;
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
