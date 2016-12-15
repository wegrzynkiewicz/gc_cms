<?php

$staff = GC\Model\Staff::createFromSession();

$frame = "page";

$parent_id = $_SEGMENTS[1];
$page = GC\Model\Page::selectWithFrameByPrimaryId($parent_id);
$frame_id = $page['frame_id'];

$breadcrumbs->push("/admin/page/module/list/$parent_id", "Moduły na stronie %s", [$page['name']]);
