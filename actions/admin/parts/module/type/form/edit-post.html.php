<?php

require ACTIONS_PATH."/admin/parts/module/type/form/_import.php";

$emails = def($_POST, 'emails', []);
sort($emails);
$settings['emails'] = $emails;

GC\Model\Module\Module::updateByPrimaryId($module_id, [
    'content' => post('form'),
    'theme' => post('theme'),
    'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
]);

flashBox(trans('Moduł formularza został zaktualizowany.'));
redirect($breadcrumbs->getLast('uri'));
