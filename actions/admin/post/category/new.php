<?php

$headTitle = trans("Tworzenie węzła w");

$staff->redirectIfUnauthorized();

$tax_id = intval(array_shift($_SEGMENTS));
$menu_id = 0;

if(wasSentPost($_POST)) {
    PostCategory::insert([
        'name' => $_POST['name'],
    ], $tax_id);
	redirect("/admin/post/category/list/$tax_id");
}

$taxonomy = PostTaxonomy::selectByPrimaryId($tax_id);
$headTitle .= makeLink("/admin/post/category/list/$tax_id", $taxonomy['name']);

require_once ACTIONS_PATH.'/admin/post/category/form.html.php';
