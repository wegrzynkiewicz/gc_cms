<?php

GC\Model\Module\Module::updateByPrimaryId($module_id, [
    'content' => $_POST['content'],
    'theme' => 'default',
]);

GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
