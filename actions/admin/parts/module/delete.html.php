<?php

$parent_id = intval(array_shift($_SEGMENTS));
$module_id = intval($_POST['module_id']);

$module = GCC\Model\FrameModule::selectByPrimaryId($module_id);
$moduleType = $module['type'];

ModuleFile::deleteAllByModuleId($module_id);

require_once ACTIONS_PATH."/admin/parts/module/types/$moduleType/delete.html.php";

FrameModule::deleteByPrimaryId($module_id);

redirect("/admin/$frame/module/list/$parent_id");
