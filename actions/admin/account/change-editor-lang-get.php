<?php

/** Zmiana języka edytora */

$lang = array_shift($_SEGMENTS);
$availableLangs = array_keys(GC\Container::get('config')['langs']);

if (!in_array($lang, $availableLangs)) {
    GC\Response::redirect(GC\Url::make('/admin'));
}

$_SESSION['staff']['langEditor'] = $lang;

GC\Response::redirectToRefererOrDefault('/admin');
