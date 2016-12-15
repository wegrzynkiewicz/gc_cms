<?php

/* Plik ładowany przed każdą akcją w panelu admina */

# domyślny headTitle, jeżeli zapomni się go nadać
$headTitle = trans("Panel");

$breadcrumbs = new Breadcrumbs();
$breadcrumbs->push('/admin', 'Dashboard', [], 'fa-dashboard');

# utworzenie obiektu reprezentującego pracownika, sprawdza czy jest zalogowany
$staff = Staff::createFromSession();