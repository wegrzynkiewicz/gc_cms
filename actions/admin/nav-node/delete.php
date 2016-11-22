<?php

checkPermissions();

$nav_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {
    $node_id = intval($_POST['node_id']);
    NavNodeModel::deleteByPrimaryId($node_id);
}

redirect("/admin/nav-node/list/$nav_id");
