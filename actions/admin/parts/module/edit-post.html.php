<?php

$module_id = intval(array_shift($_PARAMETERS));
$module = GC\Model\Module\Module::fetchByPrimaryId($module_id);

$type = $module['type'];

$uri->extendMask("/{$module_id}%s");

require ACTIONS_PATH."/admin/parts/module/type/{$type}/edit-post.html.php";
