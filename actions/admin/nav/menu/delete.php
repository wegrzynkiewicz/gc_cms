<?php

$staff = GC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$nav_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {
    GC\Storage\Database::transaction(function () {
        $menu_id = intval($_POST['menu_id']);
        GC\Model\Menu::deleteByPrimaryId($menu_id);
        GC\Model\Menu::deleteWithoutParentId();
    });
}

redirect("/admin/nav/menu/list/$nav_id");
