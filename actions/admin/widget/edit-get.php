<?php

$widget = GC\Model\Widget::fetchByPrimaryId($widget_id);
$type = $widget['type'];
$content = $widget['content'];

require ACTIONS_PATH."/admin/widget/type/{$type}-{$request->method}.html.php";
