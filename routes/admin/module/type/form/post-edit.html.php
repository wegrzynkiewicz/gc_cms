<?php

require ROUTES_PATH."/admin/module/type/form/_import.php";

$emails = def($_POST, 'emails', []);
sort($emails);
$settings['emails'] = $emails;

GC\Model\Module::updateByPrimaryId($module_id, [
    'content' => post('form'),
    'theme' => post('theme'),
    'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
]);

flashBox(trans('Moduł formularza został zaktualizowany.'));
redirect($breadcrumbs->getLast('uri'));
