<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

$frame_id = intval(post('frame_id'));

# pobierz rusztowanie po kluczu głównym
$page = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

# usuń rusztowanie i wszystkie jej moduły
GC\Model\Frame::deleteByFrameId($frame_id);

flashBox(trans('Produkt "%s" został usunięty.', [$page['name']]));
redirect($breadcrumbs->getLast('uri'));
