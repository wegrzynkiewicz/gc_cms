<?php

GC\Model\Menu\Menu::insertWithNavId([
    'name' => $_POST['name'],
    'type' => $_POST['type'],
    'destination' => $_POST['destination'],
    'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
], $nav_id);

GC\Response::redirect($breadcrumbs->getLastUrl());
