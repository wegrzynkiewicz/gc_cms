<?php

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

$tax_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {
    Database::transaction(function () {
        $node_id = intval($_POST['node_id']);
        PostNode::deleteByPrimaryId($node_id);
        PostNode::deleteWithoutParentId();
    });
}

redirect("/admin/post/node/list/$tax_id");
