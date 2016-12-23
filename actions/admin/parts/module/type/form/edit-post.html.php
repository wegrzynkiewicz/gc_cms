<?php

$emails = def($_POST, 'emails', []);
sort($emails);
$settings['emails'] = $emails;

GC\Model\Module::updateByPrimaryId($module_id, [
    'content' => $_POST['form'],
    'theme' => $_POST['theme'],
    'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
]);

setNotice(trans('Moduł formularza został zaktualizowany.'));

GC\Response::redirect($breadcrumbs->getLastUrl());
