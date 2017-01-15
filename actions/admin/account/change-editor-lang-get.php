<?php

/** Zmiana języka edytora */

$lang = array_shift($_SEGMENTS);
GC\Assert::installedLang($lang);
$_SESSION['staff']['langEditor'] = $lang;
GC\Response::redirect('/admin');
