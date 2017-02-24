<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/post/_import.php';

# dodaj ramkę do bazy
$frame_id = GC\Model\Frame::insert([
    'name' => post('name'),
    'type' => 'post',
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

flashBox(trans('Nowy produkt "%s" została utworzony.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
