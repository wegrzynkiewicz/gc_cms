<?php

GC\Model\Menu\Menu::insertWithNavId([
    'name' => post('name'),
    'type' => post('type'),
    'destination' => post('destination'),
    'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
], $nav_id);

GC\Response::redirect($breadcrumbs->getLastUrl());
