<?php

GC\Model\Menu::updateByPrimaryId($menu_id, [
    'name' => $_POST['name'],
    'type' => $_POST['type'],
    'destination' => $_POST['destination'],
    'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
]);

GC\Response::redirect($breadcrumbs->getLastUrl());
