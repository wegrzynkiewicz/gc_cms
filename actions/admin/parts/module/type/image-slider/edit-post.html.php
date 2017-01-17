<?php

GC\Model\Module\Module::updateByPrimaryId($module_id, [
    'theme' => post('theme'),
]);

redirect($breadcrumbs->getBeforeLast('url'));
