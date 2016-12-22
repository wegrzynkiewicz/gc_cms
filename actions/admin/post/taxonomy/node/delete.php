<?php

if (isPost()) {
    GC\Storage\Database::transaction(function () {
        $node_id = intval($_POST['node_id']);
        GC\Model\PostNode::deleteByPrimaryId($node_id);
        GC\Model\PostNode::deleteWithoutParentId();
    });
}

GC\Response::redirect($breadcrumbs->getLastUrl());
