<?php

$staff->redirectIfUnauthorized();

$nav_id = intval(array_shift($_SEGMENTS));

if (wasSentPost()) {
    Database::transaction(function () {
        $menu_id = intval($_POST['menu_id']);
        Menu::deleteByPrimaryId($menu_id);
        Menu::deleteWithoutParentId();
    });
}

redirect("/admin/nav/menu/list/$nav_id");
