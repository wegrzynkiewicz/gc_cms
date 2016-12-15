<?php

$module_id = intval($_POST['module_id']);

$module = GC\Model\FrameModule::selectByPrimaryId($module_id);
$moduleType = $module['type'];

GC\Model\ModuleFile::deleteAllByModuleId($module_id);

require_once ACTIONS_PATH."/admin/parts/module/types/$moduleType/delete.html.php";

GC\Model\FrameModule::deleteByPrimaryId($module_id);

redirect($breadcrumbs->getBeforeLastUrl());
