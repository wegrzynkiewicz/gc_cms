<?php

if(isPost()) {
    GC\Model\Menu::updateByPrimaryId($menu_id, [
        'name' => $_POST['name'],
        'type' => $_POST['type'],
        'destination' => $_POST['destination'],
        'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
    ]);
	GC\Response::redirect($breadcrumbs->getLastUrl());
}

$node = GC\Model\Menu::selectByPrimaryId($menu_id);

$headTitle = trans('Edycja węzła "%s"', [$node['name']]);
$breadcrumbs->push($request, $headTitle);

$_POST = $node;

require ACTIONS_PATH.'/admin/nav/menu/form.html.php';
