<?php

require ROUTES_PATH."/root/_only-debug.php";
require ROUTES_PATH."/root/_only-root.php";
require ROUTES_PATH."/root/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/root/_breadcrumbs.php";
require ROUTES_PATH."/root/checksum/_import.php";

GC\Model\Checksum::refreshChecksums();

flashBox(trans('Odświeżono wszystkie pliki.'));
redirect($breadcrumbs->getLast()['uri']);
