<?php

$module_id = intval($_POST['module_id']);
$module = GC\Model\Module\Module::fetchByPrimaryId($module_id);
$moduleType = $module['type'];

GC\Model\Module\File::deleteAllByForeign($module_id);
GC\Model\Module\Module::deleteModuleByPrimaryId($module_id);

setNotice($trans("%s został usunięty", [GC\Data::get('config')['modules'][$moduleType]['name']]));

GC\Response::redirect($breadcrumbs->getLastUrl());
