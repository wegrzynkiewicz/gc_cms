<?php

GC\Translator::$domain = 'admin';

$breadcrumbs = new GC\Breadcrumbs();

require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/root/_breadcrumbs.php";
