<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/popup/_import.php';

$popup_id = GC\Model\PopUp\PopUp::insert([
    'name' => post('name'),
    'type' => post('type'),
    'lang' => GC\Staff::getInstance()->getEditorLang(),
    'countdown' => post('countdown', 0),
    'show_after_datetime' => post('show_after_datetime', '0000-00-00 00:00:00'),
    'hide_after_datetime' => post('hide_after_datetime', '0000-00-00 00:00:00'),
    'content' => post('content'),
]);



flashBox(trans('Wyskakujące okienko "%s" zostało utworzone.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
