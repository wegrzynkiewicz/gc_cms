<?php

GC\Data::set('title', $trans('Twój profil użytkownika'));
GC\Url::extendMask('/account%s');
$breadcrumbs->push([
    'url' => GC\Url::mask('/profil'),
    'name' => $trans('Profil użytkownika'),
    'icon' => 'fa-user',
]);
