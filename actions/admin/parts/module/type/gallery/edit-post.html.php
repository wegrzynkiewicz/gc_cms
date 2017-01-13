<?php

$theme = $_POST['theme'];

require ACTIONS_PATH."/admin/parts/module/type/gallery/theme/{$theme}-{$request->method}.php";

GC\Model\Module\Module::updateByPrimaryId($module_id, [
    'theme' => $theme,
    'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
]);

setNotice($trans('Moduł galerii zdjęć został zaktualizowany.'));

GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
