<?php

GC\Model\Menu\Menu::updateByPrimaryId($menu_id, [
    'name' => post('name'),
    'type' => post('type'),
    'destination' => post('destination'),
    'target' => isset($_POST['target']) ? $_POST['target'] : '_self',
]);

redirect($breadcrumbs->getLast('url'));
