<?php

GC\Model\Module\Module::updateByPrimaryId($module_id, [
    'content' => post('content'),
    'theme' => 'default',
]);

redirect($breadcrumbs->getBeforeLast('uri'));
