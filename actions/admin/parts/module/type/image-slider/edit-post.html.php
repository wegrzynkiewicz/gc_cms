<?php

GC\Model\Module::updateByPrimaryId($module_id, [
    'theme' => $_POST['theme'],
]);

GC\Response::redirect($breadcrumbs->getLastUrl());
