<?php

$module_id = intval(array_shift($_PARAMETERS));

# pobierz moduł po kluczu głównym
$module = GC\Model\Module\Module::fetchByPrimaryId($module_id);

$moduleType = $module['type'];

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz zakładkę o numerze $tab_id
$tab = GC\Model\Module\Tab::select()
    ->source('::frame')
    ->equals('frame_id', $frame_id)
    ->fetch();

$uri->extendMask("/{$module_id}%s");
require ACTIONS_PATH."/admin/parts/module/type/{$moduleType}/_import.php";

$headTitle = trans('Moduły zakładki "%s"', [$tab['name']]);
$uri->extendMask("/tab/{$frame_id}/module%s");
$breadcrumbs->push([
    'uri' => $uri->mask("/grid"),
    'name' => $headTitle,
]);

$moduleName = intval(array_shift($_SEGMENTS));
if ($moduleName == 'module') {
    if (isset($_SEGMENTS[0]) and intval($_SEGMENTS[0])) {
        $module_id = intval(array_shift($_SEGMENTS));
    }
    $action = array_shift($_SEGMENTS);
    require ACTIONS_PATH."/admin/parts/module/{$action}-{$request->method}.html.php";
}
