<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/popup/_import.php';

$popup_id = intval(array_shift($_PARAMETERS));

GC\Model\PopUp\PopUp::updateByPrimaryId($popup_id, [
    'name' => post('name'),
    'type' => post('type'),
    'countdown' => post('countdown', 0),
    'show_after_datetime' => post('show_after_datetime', '0000-00-00 00:00:00'),
    'hide_after_datetime' => post('hide_after_datetime', '0000-00-00 00:00:00'),
    'content' => post('content'),
]);

$type = post('type');
require ROUTES_PATH."/admin/popup/type/{$type}-post.php";

flashBox(trans('Wyskakujące okienko "%s" zostało zaktualizowane.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
