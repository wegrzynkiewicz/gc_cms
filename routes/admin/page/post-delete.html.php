<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/page/_import.php';

$frame_id = intval(post('frame_id'));

# pobierz rusztowanie po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

# usuń rusztowanie i wszystkie jej moduły
GC\Model\Frame::deleteByFrameId($frame_id);

flashBox(trans('Strona "%s" została usunięta.', [$frame['name']]));
redirect($breadcrumbs->getLast('uri'));
