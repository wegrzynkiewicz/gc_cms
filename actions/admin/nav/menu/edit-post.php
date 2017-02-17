<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/nav/_import.php';
require ACTIONS_PATH.'/admin/nav/menu/_import.php';

$menu_id = intval(array_shift($_PARAMETERS));

GC\Model\Menu\Menu::updateByPrimaryId($menu_id, [
    'name' => post('name'),
    'destination' => post('destination'),
    'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
    'frame_id' => post('frame_id', null),
]);

# pobierz węzeł po kluczu głównym
$menu = GC\Model\Menu\Menu::select()
    ->source('::tree_frame')
    ->equals('menu_id', $menu_id)
    ->fetchObject();

flashBox($trans('Menu "%s" zostało zaktualizowane.', [$menu->getName()]));
redirect($breadcrumbs->getLast('uri'));
