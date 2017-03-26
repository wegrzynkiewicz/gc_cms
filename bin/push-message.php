<?php

/** Dodaje konto administratora do bazy danych **/

require_once __DIR__.'/_import.php';

use Mpociot\BotMan\Drivers\FacebookDriver;

echo PHP_EOL;
$message = $inputValue('Enter message: ');
if ($message) {

    $botman->say($message, '1358059864231175', FacebookDriver::class);

    echo "Message was created.".PHP_EOL;
} else {
    echo "Message was not created.".PHP_EOL;
}
