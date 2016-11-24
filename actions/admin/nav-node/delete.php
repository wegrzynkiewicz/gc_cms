<?php

checkPermissions();

$nav_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {
    $menu_id = intval($_POST['menu_id']);
    NavMenuModel::deleteByPrimaryId($menu_id);
}

redirect("/admin/nav-node/list/$nav_id");
