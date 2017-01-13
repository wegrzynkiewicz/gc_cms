<?php

GC\Model\Staff\Staff::updateByPrimaryId($staff['staff_id'], [
    'lang' => post('lang'),
]);

GC\Response::redirect($breadcrumbs->getBeforeLastUrl());
