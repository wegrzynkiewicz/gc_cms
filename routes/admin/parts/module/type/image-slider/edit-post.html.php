<?php

require ROUTES_PATH."/admin/parts/module/type/image-slider/_import.php";

GC\Model\Module\Module::updateByPrimaryId($module_id, [
    'theme' => post('theme'),
]);

redirect($breadcrumbs->getBeforeLast('uri'));
