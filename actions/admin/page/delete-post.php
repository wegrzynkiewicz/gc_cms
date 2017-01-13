<?php

$page_id = intval($_POST['page_id']);
$page = GC\Model\Page::selectWithFrameByPrimaryId($page_id);
GC\Model\Page::deleteFrameByPrimaryId($page_id);
setNotice($trans('Strona "%s" została usunięta.', [$page['name']]));
GC\Response::redirect($breadcrumbs->getLastUrl());
