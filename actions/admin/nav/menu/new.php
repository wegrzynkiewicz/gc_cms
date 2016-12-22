<?php

$headTitle = trans('Dodawanie nowego węzła');
$breadcrumbs->push($request, $headTitle);

$menu_id = 0;

if(isPost()) {
    GC\Model\Menu::insertWithNavId([
        'name' => $_POST['name'],
        'type' => $_POST['type'],
        'destination' => $_POST['destination'],
        'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
    ], $nav_id);

	redirect($breadcrumbs->getBeforeLastUrl());
}

require ACTIONS_PATH.'/admin/nav/menu/form.html.php';
