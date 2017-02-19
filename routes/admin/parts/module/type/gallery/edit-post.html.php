<?php

require ROUTES_PATH."/admin/parts/module/type/gallery/_import.php";

$theme = $_POST['theme'];

require ROUTES_PATH."/admin/parts/module/type/gallery/theme/{$theme}-{$request->method}.php";

GC\Model\Module\Module::updateByPrimaryId($module_id, [
    'theme' => $theme,
    'settings' => json_encode($settings, JSON_UNESCAPED_UNICODE),
]);

flashBox(trans('Moduł galerii zdjęć został zaktualizowany.'));
redirect($breadcrumbs->getBeforeLast('uri'));
