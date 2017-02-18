<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/widget/_import.php';

$widget_id = intval(array_shift($_PARAMETERS));
$widget = GC\Model\Widget::fetchByPrimaryId($widget_id);
$type = $widget['type'];

require ACTIONS_PATH."/admin/widget/types/{$type}-post.html.php";

redirect($breadcrumbs->getLast('uri'));
