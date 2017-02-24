<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/page/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

GC\Model\Frame::updateByFrameId($frame_id, [
    'name' => post('name'),
    'slug' => normalizeSlug(post('slug')),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->relative(post('image')),
    'publication_datetime' => post('publication_datetime', sqldate()),
    'visibility' => post('visibility'),
]);

flashBox(trans('Strona "%s" została zaktualizowana.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
