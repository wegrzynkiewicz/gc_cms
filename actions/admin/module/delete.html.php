<?php

$parent_id = intval(array_shift($_SEGMENTS));
$module_id = intval($_POST['module_id']);

FrameModule::deleteByPrimaryId($module_id);

redirect("/admin/$parentSegment/module/list/$parent_id");
