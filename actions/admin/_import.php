<?php

/* Plik ładowany przed każdą akcją w panelu admina */

GC\Url::extendMask('/admin%s');

$breadcrumbs = new GC\Breadcrumbs();
$breadcrumbs->push('/admin', 'Dashboard', 'fa-dashboard');
GC\Container::set('breadcrumbs', $breadcrumbs);

# utworzenie obiektu reprezentującego pracownika, sprawdza czy jest zalogowany
GC\Container::set('staff', GC\Auth\Staff::createFromSession());
