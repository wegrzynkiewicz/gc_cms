<?php

require ACTIONS_PATH.'/admin/_import.php';

$frame_id = intval(post('frame_id'));

# pobranie zakładki z ramką
$tab = GC\Model\Module\Tab::select()
    ->source('::frame')
    ->equals('frame_id', $frame_id)
    ->fetch();

# usuń zakładkę
GC\Model\Frame::deleteByFrameId($frame_id);

flashBox($trans('Zakładka "%s" została usunięta.', [$tab['name']]));
http_response_code(204);
