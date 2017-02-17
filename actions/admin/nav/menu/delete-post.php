<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/nav/_import.php';
require ACTIONS_PATH.'/admin/nav/menu/_import.php';

$menu_id = intval($_POST['menu_id']);

# usuń węzeł i podwęzły nawigacji
GC\Model\Menu\Menu::deleteByMenuId($menu_id);

redirect($breadcrumbs->getLast('uri'));
