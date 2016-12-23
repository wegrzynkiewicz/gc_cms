<?php

$headTitle = trans('Twój profil użytkownika');
GC\Url::extendMask('/account%s');
$breadcrumbs->push(GC\Url::mask('/profil'), trans('Profil użytkownika'), 'fa-user');
