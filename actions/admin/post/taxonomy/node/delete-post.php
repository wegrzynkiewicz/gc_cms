<?php

$node_id = intval($_POST['node_id']);
GC\Model\Post\Node::deleteNodeByPrimaryId($node_id);
GC\Response::redirect($breadcrumbs->getLast('url'));
