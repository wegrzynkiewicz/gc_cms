<?php

$staff = GrafCenter\CMS\Model\Staff::createFromSession();
$staff->redirectIfUnauthorized();

$nav_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {
    GrafCenter\CMS\Storage\Database::transaction(function () {
        $menu_id = intval($_POST['menu_id']);
        GrafCenter\CMS\Model\Menu::deleteByPrimaryId($menu_id);
        GrafCenter\CMS\Model\Menu::deleteWithoutParentId();
    });
}

redirect("/admin/nav/menu/list/$nav_id");
