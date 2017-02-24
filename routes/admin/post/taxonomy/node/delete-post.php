<?php

require ROUTES_PATH.'/admin/_import.php';
require ROUTES_PATH.'/admin/post/_import.php';
require ROUTES_PATH.'/admin/post/taxonomy/_import.php';
require ROUTES_PATH.'/admin/post/taxonomy/node/_import.php';

$frame_id = intval(post('frame_id'));

# pobierz węzeł po kluczu głównym
$node = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

# usuń stronę i wszystkie jej moduły
GC\Model\Post\Tree::deleteByFrameId($frame_id);

flashBox(trans('Węzeł "%s" został usunięty.', [$node['name']]));
redirect($breadcrumbs->getLast('uri'));
