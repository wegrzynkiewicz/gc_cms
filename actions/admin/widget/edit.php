<?php

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$widget_id = intval(array_shift($_SEGMENTS));
$widget = GC\Model\Widget::selectByPrimaryId($widget_id);
$type = $widget['type'];
$content = $widget['content'];

require_once sprintf(ACTIONS_PATH.'/admin/widget/types/%s.html.php', $type);
