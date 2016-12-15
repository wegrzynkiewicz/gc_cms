<?php

$staff = GrafCenter\CMS\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$tax_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {
    GrafCenter\CMS\Storage\Database::transaction(function () {
        $node_id = intval($_POST['node_id']);
        GrafCenter\CMS\Model\PostNode::deleteByPrimaryId($node_id);
        GrafCenter\CMS\Model\PostNode::deleteWithoutParentId();
    });
}

redirect("/admin/post/node/list/$tax_id");
