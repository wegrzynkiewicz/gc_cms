<?php

$data = file_get_contents("php://input");

dd(json_decode($data, true));

$botman->hears('siema', function ($bot) {
    $bot->reply("No siema eniu!");
});

$botman->listen();
