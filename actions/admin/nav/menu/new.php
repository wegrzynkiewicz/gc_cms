<?php

$headTitle = trans("Tworzenie węzeła w nawigacji");

$staff = GrafCenter\CMS\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$nav_id = intval(array_shift($_SEGMENTS));
$menu_id = 0;

if(wasSentPost($_POST)) {
    GrafCenter\CMS\Model\Menu::insert([
        'name' => $_POST['name'],
        'type' => $_POST['type'],
        'destination' => $_POST['destination'],
        'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
    ], $nav_id);
	redirect("/admin/nav/menu/list/$nav_id");
}

$nav = GrafCenter\CMS\Model\MenuTaxonomy::selectByPrimaryId($nav_id);
$headTitle .= makeLink("/admin/nav/menu/list/$nav_id", $nav['name']);

require_once ACTIONS_PATH.'/admin/nav/menu/form.html.php';
