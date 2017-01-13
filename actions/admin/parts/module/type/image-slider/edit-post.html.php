<?php

GC\Model\Module\Module::updateByPrimaryId($module_id, [
    'theme' => post('theme'),
]);

GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
