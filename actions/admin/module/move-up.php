<?php

$staff->redirectIfUnauthorized();

$module_id = intval(array_shift($_SEGMENTS));
$page_id = intval(array_shift($_SEGMENTS));

FrameModuleModel::moveUp($module_id);

redirect("/admin/module/list/$page_id");
