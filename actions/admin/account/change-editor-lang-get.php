<?php

/** Zmiana języka edytora */

$lang = array_shift($_SEGMENTS);
GC\Assert::installedLang($lang);
$_SESSION['langEditor'] = $lang;
redirect('/admin');
