<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/dump/_import.php";

GC\Storage\Backup::make(post('name'));
redirect($breadcrumbs->getLast()['uri']);
