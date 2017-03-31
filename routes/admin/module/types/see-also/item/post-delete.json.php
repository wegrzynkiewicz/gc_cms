<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";

$frame_id = intval(post('frame_id'));

// pobierz stronę po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

// pobranie zakładki z ramką
GC\Model\Module\Tab::delete()
    ->equals('frame_id', $frame_id)
    ->execute();

flashBox(trans('Strona "%s" nie będzie już dłużej wyświetlana.', [$frame['name']]));
http_response_code(204);
