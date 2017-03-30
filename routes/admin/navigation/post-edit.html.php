<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/navigation/_import.php";

$navigation_id = intval(array_shift($_PARAMETERS));

# usuń każdy istniejący workname, aby nie było identycznego
GC\Model\Navigation::update()
    ->set([
        'workname' => ''
    ])
    ->equals('workname', post('workname'))
    ->execute();

# wstaw nawigację
GC\Model\Navigation::updateByPrimaryId($navigation_id, [
    'name' => post('name'),
    'workname' => post('workname'),
    'maxlevels' => post('maxlevels'),
]);

flashBox(trans('Nawigacja "%s" została zaktualizowana.', [post('name')]));
redirect($breadcrumbs->getLast()['uri']);
