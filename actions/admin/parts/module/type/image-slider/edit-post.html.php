<?php

GC\Model\Module\Module::updateByPrimaryId($module_id, [
    'theme' => $_POST['theme'],
]);

GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
