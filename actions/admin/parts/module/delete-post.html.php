<?php

$module_id = intval($_POST['module_id']);
$module = GC\Model\Module::selectByPrimaryId($module_id);
$moduleType = $module['type'];

GC\Model\ModuleFile::deleteAllByForeign($module_id);
GC\Model\Module::deleteModuleByPrimaryId($module_id);

setNotice(trans("%s został usunięty", [$config['modules'][$moduleType]['name']]));

GC\Response::redirect($breadcrumbs->getLastUrl());