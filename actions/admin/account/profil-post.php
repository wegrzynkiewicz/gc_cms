<?php

require ACTIONS_PATH.'/admin/_import.php';
require ACTIONS_PATH.'/admin/account/_import.php';

$staff_id = $staff['staff_id'];
GC\Model\Staff\Staff::updateByPrimaryId($staff_id, [
    'lang' => post('lang'),
]);

redirect($breadcrumbs->getBeforeLast('uri'));
