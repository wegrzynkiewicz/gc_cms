<?php

/** Zmiana języka edytora */

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/account/_import.php";

$lang = array_shift($_SEGMENTS);
GC\Validation\Assert::installedLang($lang);
$_SESSION['langEditor'] = $lang;

redirect($_SERVER['HTTP_REFERER']);
