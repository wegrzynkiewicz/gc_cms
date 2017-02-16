<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz stronę po kluczu głównym
$page = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

GC\Model\Frame::deleteFrameByPrimaryId($frame_id);

flashBox($trans('Strona "%s" została usunięta.', [$page['name']]));
redirect($breadcrumbs->getLast('uri'));
