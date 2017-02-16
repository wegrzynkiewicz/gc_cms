<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/page/_import.php';

# pobierz rusztowanie o takim samym slugu, jeżeli slug został wprowadzony
$slug = post('slug');
if ($slug and !GC\Validate::slug($slug)) {
    $error['slug'] = $trans('Odnośnik o takim adresie został już zarezerwowany');
}

if (isset($error)) {
    return display(ACTIONS_PATH.'/admin/page/new-get.php');
}

$frame_id = GC\Model\Frame::insert([
    'name' => post('name'),
    'type' => 'page',
    'lang' => $staff->getEditorLang(),
    'slug' => $slug,
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->upload(post('image')),
]);

flashBox($trans('Nowa strona "%s" została utworzona.', [post('name')]));
redirect($breadcrumbs->getLast('uri'));
