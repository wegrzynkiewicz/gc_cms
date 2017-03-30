<?php

$taxonomy_id = GC\Model\Frame::select()
    ->source('::tree')
    ->equals('frame_id', $frame_id)
    ->fetch()['taxonomy_id'];

require ROUTES_PATH.'/admin/frame/parts/_taxonomy-breadcrumbs.php';

$headTitle = trans('Edycja węzła podziału produktu: %s', [$frame['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

echo render(ROUTES_PATH.'/admin/frame/parts/_form.html.php', [
    'nameCaption' => trans('Nazwa podziału produktów'),
]);
