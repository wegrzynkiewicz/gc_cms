<?php

$module_id = intval(array_shift($_PARAMETERS));

# pobierz moduł po kluczu głównym
$module = GC\Model\Module::fetchByPrimaryId($module_id);

$moduleType = $module['type'];

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz zakładkę o numerze $tab_id
$tab = GC\Model\Module\Tab::select()
    ->source('::frame')
    ->equals('frame_id', $frame_id)
    ->fetch();

require ROUTES_PATH."/admin/module/type/{$moduleType}/_import.php";

$headTitle = trans('Moduły zakładki: %s', [$tab['name']]);
$breadcrumbs->push([
    'uri' => $uri->make("/grid"), //TODO:
    'name' => $headTitle,
]);

$moduleName = intval(array_shift($_SEGMENTS));
if ($moduleName == 'module') {
    if (isset($_SEGMENTS[0]) and intval($_SEGMENTS[0])) {
        $module_id = intval(array_shift($_SEGMENTS));
    }

    require ROUTES_PATH."/admin/module/_detect-route.html.php";
}
