<?php

$headTitle = $trans('Formularze');
$uri->extendMask('/form%s');
$breadcrumbs->push([
    'url' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'envelope-o',
]);
