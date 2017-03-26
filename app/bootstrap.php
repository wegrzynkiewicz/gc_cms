<?php

/** Plik ładuje autoloader klas oraz funkcje */

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/etc/config.php';
require __DIR__.'/functions.php';

use Mpociot\BotMan\BotManFactory;
use Mpociot\BotMan\BotMan;

$configx = [
    'facebook_token' => 'EAAKssJ3JiawBAHBDSUt5PzMYfqscOYSPpwYYhrKJq9Ac7KuaWE2lyYhAK9r5acMDQh9ZA14GlTTHDWtCQQkGEqplVCgtzHD0rWRBknVQ9zGE4jhcRnPJhVw8nsodpTfUi5L4uG2U6ORNZAtUE4SunJZCzvFZCOFYIJztsMOZCXwZDZD',
];

$botman = BotManFactory::create($configx);
