<?php

$headTitle = trans("Moduły na stronie");

$staff->redirectIfUnauthorized();

$headTitle .= makeLink("/admin/page/list", $page['name']);

require_once ACTIONS_PATH.'/admin/parts/module/list.html.php'; ?>
