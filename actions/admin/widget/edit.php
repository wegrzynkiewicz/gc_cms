<?php

$widget = GC\Model\Widget::selectByPrimaryId($widget_id);
$type = $widget['type'];
$content = $widget['content'];

require sprintf(ACTIONS_PATH.'/admin/widget/types/%s.html.php', $type);
