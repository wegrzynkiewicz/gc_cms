<?php

$headTitle = trans("Nowy moduł na stronie");

$staff->redirectIfUnauthorized();

$headTitle .= makeLink("/admin/page/list", $page['name']);

require_once ACTIONS_PATH.'/admin/parts/module/new.html.php'; ?>
