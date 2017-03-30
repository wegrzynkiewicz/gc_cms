<?php

$taxonomy_id = GC\Model\Frame::select()
    ->source('::tree')
    ->equals('frame_id', $frame_id)
    ->fetch()['taxonomy_id'];

require ROUTES_PATH."/admin/frame/parts/_taxonomy-breadcrumbs.php";

flashBox(trans('Węzeł produktu "%s" został zaktualizowany.', [post('name')]));
