<?php

$headTitle = trans('Dodawanie nowego podziału produktu');
$breadcrumbs->push([
    'name' => $headTitle,
]);

echo render(ROUTES_PATH.'/admin/frame/_parts/form.html.php', [
    'nameCaption' => trans('Nazwa strony'),
]);
