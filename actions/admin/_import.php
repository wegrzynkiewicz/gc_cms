<?php

/* Plik ładowany przed każdą akcją w panelu admina */

# domyślny headTitle, jeżeli zapomni się go nadać
$headTitle = trans("Panel");

$surl = function($path) {
    return url("/admin{$path}");
};

$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push('/admin', 'Dashboard', 'fa-dashboard');

# utworzenie obiektu reprezentującego pracownika, sprawdza czy jest zalogowany
$staff = GC\Model\Staff::createFromSession();
