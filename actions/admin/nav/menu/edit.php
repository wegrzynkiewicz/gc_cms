<?php

$menu_id = intval(array_shift($_SEGMENTS));

if(isPost()) {
    GC\Model\Menu::updateByPrimaryId($menu_id, [
        'name' => $_POST['name'],
        'type' => $_POST['type'],
        'destination' => $_POST['destination'],
        'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
    ]);
	redirect($breadcrumbs->getLastUrl());
}

$node = GC\Model\Menu::selectByPrimaryId($menu_id);

$headTitle = trans('Edycja węzła "%s"', [$node['name']]);
$breadcrumbs->push($request, $headTitle);

$_POST = $node;

require_once ACTIONS_PATH.'/admin/nav/menu/form.html.php';
