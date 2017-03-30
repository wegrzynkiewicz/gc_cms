<?php

$headTitle = trans('Dodawanie nowego wpisu');
$breadcrumbs->push([
    'name' => $headTitle,
]);

$checkedValues = [];

echo render(ROUTES_PATH.'/admin/frame/_parts/form.html.php', [
    'nameCaption' => trans('Nazwa wpisu'),
]);
