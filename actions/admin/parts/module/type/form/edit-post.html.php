<?php

$emails = def($_POST, 'emails', []);
sort($emails);
$settings['emails'] = $emails;

GC\Model\Module\Module::updateByPrimaryId($module_id, [
    'content' => post('form'),
    'theme' => post('theme'),
    'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
]);

setNotice($trans('Moduł formularza został zaktualizowany.'));

redirect($breadcrumbs->getBeforeLast('uri'));
