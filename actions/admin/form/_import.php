<?php

$headTitle = $trans('Formularze');
$uri->extendMask('/form%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/list'),
    'name' => $headTitle,
    'icon' => 'envelope-o',
]);
