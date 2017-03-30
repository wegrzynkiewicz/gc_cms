<?php

$emails = post('emails', []);
sort($emails);
$settings['emails'] = $emails;

GC\Model\Module::updateByPrimaryId($module_id, [
    'content' => post('form'),
    'theme' => post('theme'),
    'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
]);

flashBox(trans('Moduł formularza został zaktualizowany.'));
