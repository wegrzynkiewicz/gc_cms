<?php

require ROUTES_PATH."/admin/_import.php";
require ROUTES_PATH."/admin/_breadcrumbs.php";
require ROUTES_PATH."/admin/navigation/_import.php";

$navigation_id = intval(array_shift($_PARAMETERS));

require ROUTES_PATH."/admin/navigation/node/_import.php";

# dekoduj nadesłaną wartość position
$positions = json_decode(post('positions', []), true);
GC\Model\Navigation\Tree::insertPositionsToNavigation($positions, $navigation_id);

flashBox(trans('Pozycja węzłów została zapisana.'));
redirect($breadcrumbs->getLast()['uri']);
