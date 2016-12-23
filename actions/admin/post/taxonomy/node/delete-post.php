<?php

$node_id = intval($_POST['node_id']);
GC\Model\PostNode::deleteNodeByPrimaryId($node_id);
GC\Response::redirect($breadcrumbs->getLastUrl());
