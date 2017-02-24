<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/post/_import.php';

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

# spłaszcz nadesłane przynależności do węzłów taksonomii
$memberships = array_unchunk(post('taxonomy', []));
GC\Model\Post\Membership::updateMembership($frame_id, $memberships);

flashBox(trans('Produkt "%s" został zaktualizowany.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
