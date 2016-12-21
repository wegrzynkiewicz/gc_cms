<?php

/** Zmiana języka edytora */

$lang = array_shift($_SEGMENTS);
$availableLangs = array_keys($config['langs']);

if (!in_array($lang, $availableLangs)) {
    redirect($surl());
}

$_SESSION['lang']['editor'] = $lang;

redirectToRefererOrDefault($surl());
