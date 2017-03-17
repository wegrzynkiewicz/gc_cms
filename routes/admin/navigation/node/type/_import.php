<?php

$node_id = intval(array_shift($_PARAMETERS));

# pobranie węzła o zadanym kluczu
$node = GC\Model\Navigation\Node::select()
    ->fields('::withFrameFields, navigation_id')
    ->source('::withFrameSource')
    ->equals('node_id', $node_id)
    ->fetchObject();

if ($node) {
    $_POST = $node->getData();
}
