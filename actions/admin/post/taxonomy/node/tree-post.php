<?php

$positions = json_decode($_POST['positions'], true);
$positions = array_filter($positions, function ($node) {
    return isset($node['id']);
});
GC\Model\Post\Tree::update($tax_id, $positions);

GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
