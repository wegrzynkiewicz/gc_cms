<?php

GC\Model\Module\Module::updateByPrimaryId($module_id, [
    'content' => post('content'),
    'theme' => 'default',
]);

GC\Response::redirect($breadcrumbs->getBeforeLast('url'));
