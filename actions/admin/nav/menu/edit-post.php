<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/nav/_import.php';
require ACTIONS_PATH.'/admin/nav/menu/_import.php';

GC\Model\Menu\Menu::updateByPrimaryId($menu_id, [
    'name' => post('name'),
    'type' => post('type'),
    'destination' => post('destination'),
    'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
]);

redirect($breadcrumbs->getLast('uri'));
