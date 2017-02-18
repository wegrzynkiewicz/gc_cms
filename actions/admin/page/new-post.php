<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

$frame_id = GC\Model\Frame::insert([
    'name' => post('name'),
    'type' => 'page',
    'slug' => normalizeSlug(post('slug')),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->relative(post('image')),
]);

flashBox(trans('Nowa strona "%s" została utworzona.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
