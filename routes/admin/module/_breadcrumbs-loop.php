<?php

while (true) {

    $frame = GC\Model\Frame::select()
        ->equals('frame_id', $frame_id)
        ->fetch();

    require ROUTES_PATH."/admin/frame/_breadcrumbs-module.php";

    if ($frame['type'] !== 'tab') {
        require ROUTES_PATH."/admin/frame/_breadcrumbs-edit.php";
    }

    $tab = GC\Model\Module\Tab::select()
        ->fields('module_id')
        ->equals('frame_id', $frame_id)
        ->fetch();

    if (!$tab) {
        break;
    }

    $module_id = $tab['module_id'];
    $module = GC\Model\Module::select()
        ->source('::grid')
        ->equals('module_id', $module_id)
        ->fetch();

    require ROUTES_PATH."/admin/module/_breadcrumbs-edit.php";

    $frame_id = $module['frame_id'];
}

$frameType = $frame['type'];
require ROUTES_PATH."/admin/frame/_breadcrumbs-list.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";

$breadcrumbs->reverse();
