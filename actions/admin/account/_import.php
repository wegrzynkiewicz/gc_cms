<?php

$headTitle = $trans('Profil użytkownika');
$uri->extendMask('/account%s');
$breadcrumbs->push([
    'url' => $uri->mask('/profil'),
    'name' => $headTitle,
    'icon' => 'user',
]);
