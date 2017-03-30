<?php

$headTitle = trans('Edycja podziału wpisów: %s', [$frame['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

echo render(ROUTES_PATH."/admin/frame/parts/_form.html.php", [
    'nameCaption' => trans('Nazwa podziału wpisów'),
]);
