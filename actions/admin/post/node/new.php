<?php

$headTitle = trans("Tworzenie węzła w");

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$tax_id = intval(array_shift($_SEGMENTS));
$menu_id = 0;

if(wasSentPost($_POST)) {
    GCC\Model\PostNode::insert([
        'name' => $_POST['name'],
    ], $tax_id);
	redirect("/admin/post/node/list/$tax_id");
}

$taxonomy = GCC\Model\PostTaxonomy::selectByPrimaryId($tax_id);
$headTitle .= makeLink("/admin/post/node/list/$tax_id", $taxonomy['name']);

require_once ACTIONS_PATH.'/admin/post/node/form.html.php';
