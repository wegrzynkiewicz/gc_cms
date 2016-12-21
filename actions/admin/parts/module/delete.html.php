<?php

$module = GC\Model\Module::selectByPrimaryId($module_id);
$moduleType = $module['type'];

GC\Model\ModuleFile::deleteAllByModuleId($module_id);

require_once ACTIONS_PATH."/admin/parts/module/types/$moduleType/delete.html.php";

GC\Model\Module::deleteRecursiveByPrimaryId($module_id);

setNotice(trans("%s został usunięty", [$config['modules'][$moduleType]['name']]));

redirect($breadcrumbs->getLastUrl());
