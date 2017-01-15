<?php

$headTitle = $trans('Profil użytkownika');
GC\Url::extendMask('/account%s');
$breadcrumbs->push([
    'url' => GC\Url::mask('/profil'),
    'name' => $headTitle,
    'icon' => 'fa-user',
]);
