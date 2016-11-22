<?php

$headTitle = trans("Edycja węzła w nawigacji");

checkPermissions();

$node_id = intval(array_shift($_SEGMENTS));
$nav_id = intval(array_shift($_SEGMENTS));

if(wasSentPost($_POST)) {
    NavNodeModel::update($node_id, [
        'name' => $_POST['name'],
        'type' => $_POST['type'],
        'destination' => $_POST['destination'],
        'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
    ]);
	redirect("/admin/nav-node/list/$nav_id");
}

$node = NavNodeModel::selectByPrimaryId($node_id);
$nav = NavModel::selectByPrimaryId($nav_id);
$headTitle .= makeLink("/admin/nav-node/list/$nav_id", $nav['name']);
$nodeType = $node['type'];

$_POST = $node;

require_once ACTIONS_PATH.'/admin/nav-node/form.html.php';
