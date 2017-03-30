<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/navigation/_import.php";

# usuń każdy istniejący workname, aby nie było identycznego
GC\Model\Navigation::update()
    ->set([
        'workname' => ''
    ])
    ->equals('workname', post('workname'))
    ->execute();

# wstaw nawigację
GC\Model\Navigation::insert([
    'name' => post('name'),
    'lang' => GC\Staff::getInstance()->getEditorLang(),
    'workname' => post('workname'),
    'maxlevels' => post('maxlevels'),
]);

flashBox(trans('Nawigacja "%s" została utworzona.', [post('name')]));
redirect($breadcrumbs->getLast()['uri']);
