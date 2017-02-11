<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/nav/_import.php';
require ACTIONS_PATH.'/admin/nav/menu/_import.php';

$menu_id = intval($_POST['menu_id']);
GC\Model\Menu\Menu::deleteNodeByPrimaryId($menu_id);
redirect($breadcrumbs->getLast('uri'));
