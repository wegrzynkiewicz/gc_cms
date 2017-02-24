<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/post/_import.php';
require ROUTES_PATH.'/admin/post/taxonomy/_import.php';
require ROUTES_PATH.'/admin/post/taxonomy/node/_import.php';

$name = post('name');

# wstaw ramkę do bazy z podstawowymi danymi
$frame_id = GC\Model\Frame::insert([
    'name' => $name,
    'type' => 'post-node',
    'slug' => normalizeSlug(post('slug')),
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->relative(post('image')),
    'publication_datetime' => post('publication_datetime', sqldate()),
    'visibility' => post('visibility'),
]);

# pobierz największą pozycję dla węzła w drzewie
$position = GC\Model\Post\Tree::select()
    ->fields('MAX(position) AS max')
    ->equals('tax_id', $tax_id)
    ->equals('parent_id', null)
    ->fetch()['max'];

# dodaj węzeł do pozycji w drzewie taksonomi
GC\Model\Post\Tree::insert([
    'tax_id' => $tax_id,
    'frame_id' => $frame_id,
    'parent_id' => null,
    'position' => $position+1,
]);

flashBox(trans('Nowy węzeł "%s" dostał dodany do "%s".', [$name, $taxonomy['name']]));
redirect($breadcrumbs->getLast('uri'));
