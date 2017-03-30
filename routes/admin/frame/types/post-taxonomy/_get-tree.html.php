<?php

$taxonomy_id = $frame_id;

require ROUTES_PATH.'/admin/frame/parts/_taxonomy-breadcrumbs.php';

$tree = GC\Model\Frame::select()
    ->source('::tree')
    ->equals('taxonomy_id', $taxonomy_id)
    ->fetchTree();

echo render(ROUTES_PATH.'/admin/frame/parts/_tree-taxonomy.html.php', [
    'addHref' => $uri->make("/admin/frame/new/post-node/{$frame_id}"),
]);
