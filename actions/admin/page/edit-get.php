<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz rusztowanie po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

# jeżeli nie znaleziono rusztowania wtedy przekieruj
if (!$frame) {
    flashBox(trans('Wystąpił błąd. Szukana strona nie została znaleziona.'), 'danger');
    redirect($breadcrumbs->getLast('uri'));
}

$headTitle = trans('Edycja strony %s', [$frame['name']]);
$breadcrumbs->push([
    'name' => $headTitle,
]);

$_POST = $frame;

require ACTIONS_PATH.'/admin/page/form.html.php';
