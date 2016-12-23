<?php

/* Plik ładowany przed każdą akcją w panelu admina */

# domyślny headTitle, jeżeli zapomni się go nadać
$headTitle = trans($config['adminNavbarTitle']);

GC\Url::extendMask('/admin%s');

$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push('/admin', 'Dashboard', 'fa-dashboard');

# utworzenie obiektu reprezentującego pracownika, sprawdza czy jest zalogowany
$staff = GC\Model\Staff::createFromSession();
