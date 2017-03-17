<?php

$taxonomy_id = $frame_id;

require ROUTES_PATH."/admin/frame/_parts/taxonomy-breadcrumbs.php";

$tree = GC\Model\Frame::select()
    ->source('::tree')
    ->equals('taxonomy_id', $taxonomy_id)
    ->fetchTree();

echo render(ROUTES_PATH.'/admin/frame/_parts/tree-taxonomy.html.php', [
    'addHref' => $uri->mask("/new/product-node/{$frame_id}"),
]);
