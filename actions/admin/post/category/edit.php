<?php

$headTitle = trans("Edycja węzła w ");

$staff->redirectIfUnauthorized();

$post_id = intval(array_shift($_SEGMENTS));
$tax_id = intval(array_shift($_SEGMENTS));

if(wasSentPost($_POST)) {
    PostCategory::updateByPrimaryId($post_id, [
        'name' => $_POST['name'],
    ]);
	redirect("/admin/post/category/list/$tax_id");
}

$node = PostCategory::selectByPrimaryId($post_id);
$taxonomy = PostTaxonomy::selectByPrimaryId($tax_id);
$headTitle .= makeLink("/admin/post/category/list/$tax_id", $taxonomy['name']);

$_POST = $node;

require_once ACTIONS_PATH.'/admin/post/category/form.html.php';
