<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/popup/_import.php";

$popup_id = intval(post('popup_id'));

// pobierz popupa po kluczu głównym
$popup = GC\Model\PopUp\PopUp::select()
    ->equals('popup_id', $popup_id)
    ->fetch();

// usuń popupa
GC\Model\PopUp\PopUp::deleteByPrimaryId($popup_id);

flashBox(trans('Wyskakujące okienko "%s" zostało usunięte.', [$popup['name']]));
redirect($breadcrumbs->getLast()['uri']);
