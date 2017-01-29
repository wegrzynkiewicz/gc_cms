<?php

$frame_id = GC\Model\Module\Frame::insert([
    'name' => post('name'),
    'type' => 'page',
    'keywords' => post('keywords'),
    'description' => post('description'),
    'image' => $uri->upload($_POST['image']),
]);

GC\Model\Page::insert([
    'frame_id' => $frame_id,
]);

setNotice($trans('Nowa strona "%s" została utworzona.', [$_POST['name']]));

redirect($breadcrumbs->getLast('url'));
