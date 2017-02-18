<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/product/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz stronę po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

# jeżeli nie znaleziono rusztowania wtedy przekieruj
if (!$frame) {
    flashBox($trans('Wystąpił błąd. Szukany produkt nie został znaleziony.'), 'danger');
    redirect($breadcrumbs->getLast('uri'));
}

$headTitle = $trans('Edytowanie produktu "%s"', [$frame['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $frame;

# pobranie kluczy node_id, do których przynależy produkt
$checkedValues = array_keys(GC\Model\Product\Membership::select()
    ->fields(['node_id'])
    ->equals('frame_id', $frame_id)
    ->fetchByMap('node_id', 'node_id'));

require ACTIONS_PATH.'/admin/product/form.html.php';
