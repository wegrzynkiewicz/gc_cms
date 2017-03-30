<?php

require ROUTES_PATH.'/admin/_import.php';

$module_id = intval(post('module_id'));
$module = GC\Model\Module::select()
    ->source('::grid')
    ->equals('module_id', $module_id)
    ->fetch();

$frame_id = $module['frame_id'];

require ROUTES_PATH.'/admin/module/parts/_breadcrumbs-loop.php';

# usuń moduł i wszystkie jego dodatki
GC\Model\Module::deleteByModuleId($module_id);

flashBox(trans("%s został usunięty", [$config['module']['types'][$module['type']]['name']]));
redirect($breadcrumbs->getLast()['uri']);
