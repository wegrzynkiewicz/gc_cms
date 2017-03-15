<?php

$headTitle = trans('Edycja strony: %s', [$frame['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

display(ROUTES_PATH.'/admin/frame/_parts/form.html.php', [
    'nameCaption' => trans('Nazwa strony'),
]);
