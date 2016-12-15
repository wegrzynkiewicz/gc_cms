<?php

/* Plik ładowany przed każdą akcją w panelu admina */

# domyślny headTitle, jeżeli zapomni się go nadać
$headTitle = trans("Panel");

$breadcrumbs = new GrafCenter\CMS\Breadcrumbs();
$breadcrumbs->push('/admin', 'Dashboard', [], 'fa-dashboard');

# utworzenie obiektu reprezentującego pracownika, sprawdza czy jest zalogowany
$staff = GrafCenter\CMS\Model\Staff::createFromSession();
