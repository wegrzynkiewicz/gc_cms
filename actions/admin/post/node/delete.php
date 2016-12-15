<?php

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$tax_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {
    GCC\Storage\Database::transaction(function () {
        $node_id = intval($_POST['node_id']);
        GCC\Model\PostNode::deleteByPrimaryId($node_id);
        GCC\Model\PostNode::deleteWithoutParentId();
    });
}

redirect("/admin/post/node/list/$tax_id");
