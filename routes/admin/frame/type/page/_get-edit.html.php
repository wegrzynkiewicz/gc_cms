<?php

$headTitle = trans('Edycja strony: %s', [$frame['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

display(ROUTES_PATH.'/admin/frame/_form.html.php', [
    'nameCaption' => trans('Nazwa strony'),
]);
