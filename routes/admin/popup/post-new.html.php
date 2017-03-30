<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/_breadcrumbs.php';
require ROUTES_PATH.'/admin/popup/_import.php';

$frames = post('frames', []);
$display = empty($frames) ? 'all' : 'frames';

# wstaw wyskakujące okienko do bazy danych
$popup_id = GC\Model\PopUp\PopUp::insert([
    'name' => post('name'),
    'type' => post('type'),
    'display' => $display,
    'lang' => GC\Staff::getInstance()->getEditorLang(),
    'countdown' => post('countdown', 0),
    'show_after_datetime' => post('show_after_datetime', '0000-00-00 00:00:00'),
    'hide_after_datetime' => post('hide_after_datetime', '0000-00-00 00:00:00'),
]);

GC\Model\PopUp\Display::updateFrames($popup_id, $frames);

$type = post('type');
require ROUTES_PATH."/admin/popup/type/{$type}-post.php";

flashBox(trans('Wyskakujące okienko "%s" zostało utworzone.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
