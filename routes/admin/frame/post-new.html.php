<?php

require ROUTES_PATH.'/admin/_import.php';

$type = array_shift($_SEGMENTS);
GC\Validation\Assert::enum($type, array_keys($config['frame']['types']));

$data = [
    'name' => GC\Validation\Required::raw('name'),
    'type' => $type,
    'lang' => GC\Staff::getInstance()->getEditorLang(),
    'title' => GC\Validation\Optional::raw('title') ?? '',
    'keywords' => GC\Validation\Optional::raw('keywords') ?? '',
    'description' => GC\Validation\Optional::raw('description') ?? '',
    'image' => $uri->relative(GC\Validation\Optional::uri('image') ?? ''),
    'visibility' => GC\Validation\Required::enum('visibility', array_keys($config['frame']['visibility'])),
    'publication_datetime' => GC\Validation\Optional::datetime('publication_datetime') ?? sqldate(),
    'modification_datetime' => sqldate(),
    'creation_datetime' => sqldate(),
];

$data['slug'] = empty($_POST['slug'] ?? '')
    ? GC\Model\Frame::proposeSlug($data['name'], $data['lang'])
    : GC\Validation\Required::slug('slug');

# dodaj ramkę do bazy
$frame_id = GC\Model\Frame::insert($data);

require ROUTES_PATH."/admin/frame/type/{$type}/_import.php";
require ROUTES_PATH."/admin/frame/type/{$type}/_post-new.html.php";

redirect($breadcrumbs->getLast('uri'));
