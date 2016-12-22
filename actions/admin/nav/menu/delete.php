<?php

if (isPost()) {
    GC\Storage\Database::transaction(function () {
        $menu_id = intval($_POST['menu_id']);
        GC\Model\Menu::deleteByPrimaryId($menu_id);
        GC\Model\Menu::deleteWithoutParentId();
    });
}

GC\Response::redirect($breadcrumbs->getLastUrl());
