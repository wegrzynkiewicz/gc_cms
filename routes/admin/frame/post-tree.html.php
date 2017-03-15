<?php

require ROUTES_PATH.'/admin/_import.php';

$frame_id = intval(array_shift($_PARAMETERS));

# pobierz rusztowanie po kluczu głównym
$frame = GC\Model\Frame::select()
    ->equals('frame_id', $frame_id)
    ->fetch();

# dekoduj nadesłaną wartość position
$positions = json_decode(post('positions', []), true);

GC\Model\Frame\Tree::insertPositionsToTaxonomy($positions, $frame_id);

$type = $frame['type'];

require ROUTES_PATH."/admin/frame/type/{$type}/_import.php";
require ROUTES_PATH."/admin/frame/type/{$type}/_post-tree.html.php";

redirect($breadcrumbs->getLast('uri'));
