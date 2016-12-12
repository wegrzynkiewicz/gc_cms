<?php

$headTitle = trans("Zmiana języka edytora");

$staff = Staff::createFromSession();
$staff->redirectIfUnauthorized();

$lang = array_shift($_SEGMENTS);
$availableLangs = array_keys($config['langs']);

if (!in_array($lang, $availableLangs)) {
    redirect('/admin');
}

$_SESSION['lang']['editor'] = $lang;

redirectToRefererOrDefault('/admin');
