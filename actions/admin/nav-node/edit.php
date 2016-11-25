<?php

$headTitle = trans("Edycja węzła w nawigacji");

Staff::createFromSession()->redirectIfUnauthorized();

$menu_id = intval(array_shift($_SEGMENTS));
$nav_id = intval(array_shift($_SEGMENTS));

if(wasSentPost($_POST)) {
    NavMenuModel::update($menu_id, [
        'name' => $_POST['name'],
        'type' => $_POST['type'],
        'destination' => $_POST['destination'],
        'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
    ]);
	redirect("/admin/nav-node/list/$nav_id");
}

$node = NavMenuModel::selectByPrimaryId($menu_id);
$nav = NavModel::selectByPrimaryId($nav_id);
$headTitle .= makeLink("/admin/nav-node/list/$nav_id", $nav['name']);
$nodeType = $node['type'];

$_POST = $node;

require_once ACTIONS_PATH.'/admin/nav-node/form.html.php';
