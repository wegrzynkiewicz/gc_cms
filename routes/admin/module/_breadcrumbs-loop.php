<?php

$makeRecursiveBreadcrumbs = function ($frame_id) use (&$breadcrumbs, $config, $uri) {

    while (true) {

        $frame = GC\Model\Frame::select()
            ->equals('frame_id', $frame_id)
            ->fetch();

        $frameType = $frame['type'];

        require ROUTES_PATH."/admin/frame/types/{$frameType}/breadcrumbs/_module.php";

        if ($frameType !== 'tab') {
            require ROUTES_PATH."/admin/frame/types/{$frameType}/breadcrumbs/_edit.php";
            break;
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
            ->fields('frame_id, type')
            ->source('::grid')
            ->equals('module_id', $module_id)
            ->fetch();

        $moduleType = $module['type'];

        require ROUTES_PATH."/admin/module/types/{$moduleType}/_breadcrumbs-edit.php";

        $frame_id = $module['frame_id'];
    }

    require ROUTES_PATH."/admin/frame/types/{$frameType}/breadcrumbs/_list.php";
    require ROUTES_PATH."/admin/_breadcrumbs.php";

    $breadcrumbs->reverse();
};

$makeRecursiveBreadcrumbs($frame_id);
