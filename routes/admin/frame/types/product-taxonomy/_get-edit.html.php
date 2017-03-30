<?php

$headTitle = trans('Edycja podziału produktów: %s', [$frame['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

echo render(ROUTES_PATH.'/admin/frame/parts/_form.html.php', [
    'nameCaption' => trans('Nazwa podziału produktów'),
]);
