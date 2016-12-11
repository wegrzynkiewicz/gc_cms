<?php

/* Plik ładowany przed każdą akcją w panelu admina */

# domyślny headTitle, jeżeli zapomni się go nadać
$headTitle = trans("Panel");

# utworzenie obiektu reprezentującego pracownika panelu, dla kazdej akcji oprocz
$without = [
    '/admin/login',
    '/admin/account/force-change-password'
];
if (!in_array($request, $without)) {
    $staff = Staff::createFromSession();
}
