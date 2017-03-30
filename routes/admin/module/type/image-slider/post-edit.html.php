<?php

require ROUTES_PATH."/admin/module/type/image-slider/_import.php";

GC\Model\Module::updateByPrimaryId($module_id, [
    'theme' => post('theme'),
]);

redirect($breadcrumbs->getBeforeLast()['uri']);
