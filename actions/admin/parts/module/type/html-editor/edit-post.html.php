<?php

GC\Model\Module::updateByPrimaryId($module_id, [
    'content' => $_POST['content'],
    'theme' => 'default',
]);

GC\Response::redirect($breadcrumbs->getLastUrl());
