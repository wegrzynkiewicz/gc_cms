<?php

$headTitle = trans('Edycja produktu: %s', [$frame['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

# pobranie kluczy node_id, do których przynależy rusztowanie
$checkedValues = array_keys(GC\Model\Frame\Relation::select()
    ->fields(['node_id'])
    ->equals('frame_id', $frame_id)
    ->fetchByMap('node_id', 'node_id'));

display(ROUTES_PATH.'/admin/frame/_parts/form.html.php', [
    'nameCaption' => trans('Nazwa produktu'),
]);
