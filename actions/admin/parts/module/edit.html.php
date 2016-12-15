<?php

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$parent_id = intval(array_shift($_SEGMENTS));
$module_id = intval(array_shift($_SEGMENTS));

$module = GCC\Model\FrameModule::selectByPrimaryId($module_id);
$moduleType = $module['type'];
$content = $module['content'];
$settings = json_decode($module['settings'], true);

require_once ACTIONS_PATH."/admin/parts/module/types/$moduleType/edit.html.php";
