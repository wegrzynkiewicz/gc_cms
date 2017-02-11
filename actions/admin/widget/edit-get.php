<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/widget/_import.php';

$widget_id = intval(array_shift($_PARAMETERS));
$widget = GC\Model\Widget::fetchByPrimaryId($widget_id);
$type = $widget['type'];
$content = $widget['content'];

require ACTIONS_PATH."/admin/widget/type/{$type}-{$request->method}.html.php";
