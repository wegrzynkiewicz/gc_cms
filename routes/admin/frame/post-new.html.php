<?php

require ROUTES_PATH.'/admin/_import.php';

$type = array_shift($_SEGMENTS);

# dodaj ramkę do bazy
$frame_id = GC\Model\Frame::insert([
    'name' => post('name'),
    'type' => $type,
    'slug' => normalizeSlug(post('slug')),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->relative(post('image')),
    'publication_datetime' => post('publication_datetime', sqldate()),
    'visibility' => post('visibility'),
]);

require ROUTES_PATH."/admin/frame/type/{$type}/_import.php";
require ROUTES_PATH."/admin/frame/type/{$type}/_post-new.html.php";

redirect($breadcrumbs->getLast('uri'));
