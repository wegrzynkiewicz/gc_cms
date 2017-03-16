<?php

$taxonomy_id = GC\Model\Frame\Tree::select()
    ->source('::nodes')
    ->equals('frame_id', $frame_id)
    ->fetch()['taxonomy_id'];

require ROUTES_PATH."/admin/frame/_parts/taxonomy-breadcrumbs.php";

$headTitle = trans('Edycja węzła wpisu: %s', [$frame['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

echo render(ROUTES_PATH.'/admin/frame/_parts/form.html.php', [
    'nameCaption' => trans('Nazwa podziału wpisów'),
]);
