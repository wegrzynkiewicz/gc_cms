<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/page/_import.php';

$frame_id = GC\Model\Frame::insert([
    'name' => post('name'),
    'type' => 'page',
    'slug' => normalizeSlug(post('slug')),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->relative(post('image')),
    'publication_datetime' => post('publication_datetime', sqldate()),
    'visibility' => post('visibility'),
]);

flashBox(trans('Nowa strona "%s" została utworzona.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
