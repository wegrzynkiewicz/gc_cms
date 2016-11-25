<?php

Staff::createFromSession()->redirectIfUnauthorized();

$page_id = intval(array_shift($_SEGMENTS));
$module_id = intval($_POST['module_id']);
FrameModuleModel::deleteByPrimaryId($module_id);

redirect("/admin/module/list/$page_id");
