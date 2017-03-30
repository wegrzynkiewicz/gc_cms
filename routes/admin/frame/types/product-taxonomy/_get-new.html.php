<?php

$headTitle = trans('Dodawanie nowego podziału produktu');
$breadcrumbs->push([
    'name' => $headTitle,
]);

echo render(ROUTES_PATH.'/admin/frame/parts/_form.html.php', [
    'nameCaption' => trans('Nazwa strony'),
]);
