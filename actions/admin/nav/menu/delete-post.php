<?php

$menu_id = intval($_POST['menu_id']);
GC\Model\Menu::deleteNodeByPrimaryId($menu_id);
GC\Response::redirect($breadcrumbs->getLastUrl());
