<?php

$headTitle = trans("Edycja węzła w ");

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$post_id = intval(array_shift($_SEGMENTS));
$tax_id = intval(array_shift($_SEGMENTS));

if(isPost($_POST)) {
    GC\Model\PostNode::updateByPrimaryId($post_id, [
        'name' => $_POST['name'],
    ]);
	redirect("/admin/post/node/list/$tax_id");
}

$node = GC\Model\PostNode::selectByPrimaryId($post_id);
$taxonomy = GC\Model\PostTaxonomy::selectByPrimaryId($tax_id);
$headTitle .= makeLink("/admin/post/node/list/$tax_id", $taxonomy['name']);

$_POST = $node;

require_once ACTIONS_PATH.'/admin/post/node/form.html.php';
