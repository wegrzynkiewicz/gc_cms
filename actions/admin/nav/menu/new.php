<?php

$headTitle = trans('Dodawanie nowego węzła');
$breadcrumbs->push($request, $headTitle);

$menu_id = 0;

if(wasSentPost($_POST)) {
    GC\Model\Menu::insert([
        'name' => $_POST['name'],
        'type' => $_POST['type'],
        'destination' => $_POST['destination'],
        'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
    ], $nav_id);

	redirect($breadcrumbs->getBeforeLastUrl());
}

require_once ACTIONS_PATH.'/admin/nav/menu/form.html.php';
