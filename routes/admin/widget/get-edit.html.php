<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/widget/_import.php';

$widget_id = intval(array_shift($_PARAMETERS));
$widget = GC\Model\Widget::fetchByPrimaryId($widget_id);
$type = $widget['type'];
$_POST = $widget;

require ROUTES_PATH."/admin/widget/type/{$type}-get.html.php";
