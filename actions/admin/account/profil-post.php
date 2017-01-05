<?php

GC\Model\Staff\Staff::updateByPrimaryId($staff['staff_id'], [
    'lang' => $_POST['lang'],
]);

GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
