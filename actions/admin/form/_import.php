<?php

$headTitle = $trans("Formularze");
GC\Url::extendMask('/form%s');
$breadcrumbs->push([
    'url' => GC\Url::mask('/list'),
    'name' => $headTitle,
    'icon' => 'fa-envelope-o',
]);
