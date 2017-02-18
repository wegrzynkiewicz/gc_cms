<?php

/** Zmiana języka edytora */

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/account/_import.php';

$lang = array_shift($_SEGMENTS);
GC\Assert::installedLang($lang);
$_SESSION['langEditor'] = $lang;

redirect($_SERVER['HTTP_REFERER']);
