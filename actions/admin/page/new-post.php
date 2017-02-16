<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

$frame_id = GC\Model\Frame::insert([
    'name' => post('name'),
    'type' => 'page',
    'lang' => $staff->getEditorLang(),
    'slug' => empty(post('slug')) ? '' : makeSlug(post('slug')),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->upload(post('image')),
]);

flashBox($trans('Nowa strona "%s" została utworzona.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
