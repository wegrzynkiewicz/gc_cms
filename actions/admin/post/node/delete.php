<?php

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$tax_id = intval(array_shift($_SEGMENTS));

if (isPost()) {
    GC\Storage\Database::transaction(function () {
        $node_id = intval($_POST['node_id']);
        GC\Model\PostNode::deleteByPrimaryId($node_id);
        GC\Model\PostNode::deleteWithoutParentId();
    });
}

redirect("/admin/post/node/list/$tax_id");
