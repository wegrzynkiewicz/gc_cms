<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/nav/_import.php';
require ACTIONS_PATH.'/admin/nav/menu/_import.php';

GC\Model\Menu\Menu::insertWithNavId([
    'name' => post('name'),
    'type' => post('type'),
    'destination' => post('destination'),
    'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
], $nav_id);

redirect($breadcrumbs->getLast('uri'));
