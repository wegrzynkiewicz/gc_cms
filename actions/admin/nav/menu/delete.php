<?php

$staff = GCC\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$nav_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {
    GCC\Storage\Database::transaction(function () {
        $menu_id = intval($_POST['menu_id']);
        GCC\Model\Menu::deleteByPrimaryId($menu_id);
        GCC\Model\Menu::deleteWithoutParentId();
    });
}

redirect("/admin/nav/menu/list/$nav_id");
