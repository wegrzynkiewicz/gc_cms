<?php

require ACTIONS_PATH.'/admin/_import.php';

$frame_id = intval(post('frame_id'));

# zaktualizuj nazwę zakładki
GC\Model\Frame::updateByPrimaryId($frame_id, [
    'name' => post('name'),
]);

flashBox($trans('Zakładka "%s" została zaktualizowana.', [post('name')]));
http_response_code(204);
