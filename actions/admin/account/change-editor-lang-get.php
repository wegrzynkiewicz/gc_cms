<?php

/** Zmiana języka edytora */

$lang = array_shift($_SEGMENTS);
$availableLangs = array_keys($config['langs']);

if (!in_array($lang, $availableLangs)) {
    GC\Response::redirect(GC\Url::make('/admin'));
}

$_SESSION['lang']['editor'] = $lang;

GC\Response::redirectToRefererOrDefault('/admin');
