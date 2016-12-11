<?php

$staff->redirectIfUnauthorized();

$parent_id = intval(array_shift($_SEGMENTS));
$module_id = intval(array_shift($_SEGMENTS));

$module = FrameModule::selectByPrimaryId($module_id);
$moduleType = $module['type'];
$content = $module['content'];
$settings = json_decode($module['settings'], true);

require_once ACTIONS_PATH."/admin/module/types/$moduleType/edit.html.php";
