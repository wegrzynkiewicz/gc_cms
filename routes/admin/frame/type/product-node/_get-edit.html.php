<?php

$taxonomy_id = GC\Model\Frame\Tree::select()
    ->source('::nodes')
    ->equals('frame_id', $frame_id)
    ->fetch()['taxonomy_id'];
    
require ROUTES_PATH."/admin/frame/type/product-taxonomy/_breadcrumb.php";

$headTitle = trans('Edycja węzła podziału produktu: %s', [$frame['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

display(ROUTES_PATH.'/admin/frame/_parts/form.html.php', [
    'nameCaption' => trans('Nazwa podziału produktów'),
]);
