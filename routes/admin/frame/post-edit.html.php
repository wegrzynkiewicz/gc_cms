<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz rusztowanie po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

$type = $frame['type'];

GC\Model\Frame::updateByFrameId($frame_id, [
    'name' => post('name'),
    'slug' => normalizeSlug(post('slug')),
    'title' => post('title'),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->relative(post('image')),
    'publication_datetime' => post('publication_datetime', sqldate()),
    'visibility' => post('visibility'),
]);

require ROUTES_PATH."/admin/frame/type/{$type}/_import.php";
require ROUTES_PATH."/admin/frame/type/{$type}/_post-edit.html.php";

redirect($breadcrumbs->getLast('uri'));
