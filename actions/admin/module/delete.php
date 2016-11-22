<?php

checkPermissions();

$page_id = intval(array_shift($_SEGMENTS));
$module_id = intval($_POST['module_id']);
FrameModuleModel::deleteAndUpdatePositionByPrimaryId($module_id);

redirect("/admin/module/list/$page_id");
