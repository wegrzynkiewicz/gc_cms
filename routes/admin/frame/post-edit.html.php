<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz rusztowanie po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

$type = $frame['type'];

$data = [
    'name' => GC\Validation\Required::raw('name'),
    'title' => GC\Validation\Optional::raw('title') ?? '',
    'keywords' => GC\Validation\Optional::raw('keywords') ?? '',
    'description' => GC\Validation\Optional::raw('description') ?? '',
    'image' => $uri->relative(GC\Validation\Optional::uri('image') ?? ''),
    'visibility' => GC\Validation\Required::enum('visibility', array_keys($config['frame']['visibility'])),
    'publication_datetime' => GC\Validation\Optional::datetime('publication_datetime') ?? sqldate(),
    'modification_datetime' => sqldate(),
];

$data['slug'] = empty($_POST['slug'] ?? '')
    ? GC\Model\Frame::proposeSlug($data['name'], $data['lang'])
    : GC\Validation\Required::slug('slug', $frame_id);

GC\Model\Frame::updateByPrimaryId($frame_id, $data);

require ROUTES_PATH."/admin/frame/type/{$type}/_import.php";
require ROUTES_PATH."/admin/frame/type/{$type}/_post-edit.html.php";

redirect($breadcrumbs->getLast('uri'));
