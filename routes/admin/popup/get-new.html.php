<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/popup/_import.php";

$headTitle = trans('Dodawanie nowego wyskakującego okienka');
$breadcrumbs->push([
    'name' => $headTitle,
]);

$popup_id = 0;
$selectedFrames = [];

require ROUTES_PATH."/admin/popup/_form.html.php";
