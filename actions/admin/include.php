<?php

/* Plik ładowany przed każdą akcją w panelu admina */

# domyślny headTitle, jeżeli zapomni się go nadać
$headTitle = trans("Panel");

# utworzenie obiektu reprezentującego pracownika panelu
if ($request != '/admin/login') {
    $staff = Staff::createFromSession();
}
