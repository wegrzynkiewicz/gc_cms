<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/navigation/_import.php';

$navigation_id = intval(post('navigation_id'));

# pobierz nawigację po kluczu głównym
$navigation = GC\Model\Navigation::select()
    ->equals('navigation_id', $navigation_id)
    ->fetch();

# usuń nawigację
GC\Model\Navigation::deleteByNavigationId($navigation_id);

flashBox(trans('Nawigacja "%s" i wszystkie węzły zostały usunięte.', [$navigation['name']]));
redirect($breadcrumbs->getLast('uri'));
