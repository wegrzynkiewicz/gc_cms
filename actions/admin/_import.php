<?php

/* Plik ładowany przed każdą akcją w panelu admina */

GC\Url::extendMask('/admin%s');

$breadcrumbs->push('/admin', 'Dashboard', 'fa-dashboard');

# utworzenie obiektu reprezentującego pracownika, sprawdza czy jest zalogowany
GC\Data::set('staff', GC\Auth\Staff::createFromSession());
