<?php

if (count($_SEGMENTS) === 0) {
    return require_once TEMPLATE_PATH."/errors/404.html.php";
}

$lastSegment = array_pop($_SEGMENTS);
$page_id = intval($lastSegment);

if ($page_id <= 0) {
    return require_once TEMPLATE_PATH."/errors/404.html.php";
}

$page = GrafCenter\CMS\Model\Page::selectWithFrameByPrimaryId($page_id);
$frame_id = $page['frame_id'];

require_once TEMPLATE_PATH."/frames/page.html.php";
