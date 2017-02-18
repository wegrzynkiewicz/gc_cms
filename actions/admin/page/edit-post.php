<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

GC\Model\Frame::updateByFrameId($frame_id, [
    'name' => post('name'),
    'slug' => normalizeSlug(post('slug')),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->upload(post('image')),
]);

flashBox($trans('Strona "%s" została zaktualizowana.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
