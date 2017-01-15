<?php

$staff_id = GC\Data::get('staff')['staff_id'];
GC\Model\Staff\Staff::updateByPrimaryId($staff_id, [
    'lang' => post('lang'),
]);

GC\Response::redirect($breadcrumbs->getBeforeLast('url'));
