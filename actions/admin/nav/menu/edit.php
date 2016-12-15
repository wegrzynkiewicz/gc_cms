<?php

$headTitle = trans("Edycja węzła w nawigacji");

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$menu_id = intval(array_shift($_SEGMENTS));
$nav_id = intval(array_shift($_SEGMENTS));

if(wasSentPost($_POST)) {
    GC\Model\Menu::updateByPrimaryId($menu_id, [
        'name' => $_POST['name'],
        'type' => $_POST['type'],
        'destination' => $_POST['destination'],
        'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
    ]);
	redirect("/admin/nav/menu/list/$nav_id");
}

$node = GC\Model\Menu::selectByPrimaryId($menu_id);
$nav = GC\Model\MenuTaxonomy::selectByPrimaryId($nav_id);
$headTitle .= makeLink("/admin/nav/menu/list/$nav_id", $nav['name']);
$nodeType = $node['type'];

$_POST = $node;

require_once ACTIONS_PATH.'/admin/nav/menu/form.html.php';
