<?php

$headTitle = trans('Dodawanie nowej strony');
$breadcrumbs->push([
    'name' => $headTitle,
]);

display(ROUTES_PATH.'/admin/frame/_parts/form.html.php', [
    'nameCaption' => trans('Nazwa strony'),
]);
