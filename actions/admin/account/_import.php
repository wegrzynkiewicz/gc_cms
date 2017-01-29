<?php

$headTitle = $trans('Profil użytkownika');
$uri->extendMask('/account%s');
$breadcrumbs->push([
    'uri' => $uri->mask('/profil'),
    'name' => $headTitle,
    'icon' => 'user',
]);
