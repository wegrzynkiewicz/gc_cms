<?php

checkPermissions();

$module_id = intval(array_shift($_SEGMENTS));
$page_id = intval(array_shift($_SEGMENTS));

FrameModuleModel::moveDown($module_id);

redirect("/admin/module/list/$page_id");