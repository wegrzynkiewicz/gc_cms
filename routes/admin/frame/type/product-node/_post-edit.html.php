<?php

$taxonomy_id = GC\Model\Frame\Tree::select()
    ->source('::nodes')
    ->equals('frame_id', $frame_id)
    ->fetch()['taxonomy_id'];

require ROUTES_PATH."/admin/frame/type/product-taxonomy/_breadcrumb.php";

flashBox(trans('Węzeł produktu "%s" został zaktualizowany.', [post('name')]));
