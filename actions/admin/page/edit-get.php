<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz stronę po kluczu głównym
$page = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

# jeżeli nie znaleziono strony wtedy przekieruj
if (!$page) {
    flashBox($trans('Wystąpił błąd. Szukana strona nie została znaleziona.'), 'danger');
    redirect($breadcrumbs->getLast('uri'));
}

$headTitle = $trans('Edycja strony %s', [$page['name']]);
$breadcrumbs->push([
    'uri' => $request->uri,
    'name' => $headTitle,
]);

$_POST = $page;

require ACTIONS_PATH.'/admin/page/form.html.php';
